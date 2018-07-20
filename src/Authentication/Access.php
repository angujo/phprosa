<?php

/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-17
 * Time: 7:21 PM
 */

namespace Angujo\PhpRosa\Authentication;

/**
 * Class Access
 * @package Angujo\PhpRosa\Authentication
 *
 * @see https://github.com/phpmasterdotcom/UnderstandingHTTPDigest/blob/master/server.php
 */
class Access
{

    /** @var Digest|Digest2617|Basic */
    private        $auth;
    private static $realm = 'AngujoBarrack-PhpRosa:Auth';
    private static $nonce;
    private static $opaque;

    protected function __construct()
    {
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $this->auth = new Basic(['username' => $_SERVER['PHP_AUTH_USER'], 'password' => $_SERVER['PHP_AUTH_PW']]);
        } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
            $this->auth = $this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST']);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->auth = $this->httpAuthorization();
        }
        self::$nonce = md5(uniqid('', true));
        self::$opaque = md5(uniqid('', true));
        if (null === $this->auth || (!is_subclass_of($this->auth, Basic::class) && !is_a($this->auth, Basic::class))) {
            $this->authFailed('Authorization identification missing!');
        }
        call_user_func([$this->auth, 'setAppRealm'], self::$realm);
    }

    public function setAutHeader()
    {
        header(sprintf('WWW-Authenticate: Digest realm="%s", nonce="%s", opaque="%s"', self::$realm, self::$nonce, self::$opaque));
    }

    public function getUsername()
    {
        return $this->auth ? $this->auth->getUsername() : null;
    }

    public static function setRealm($realm)
    {
        self::$realm = $realm;
    }

    /**
     * @return Access|null
     */
    public static function basic()
    {
        $me = new self();
        return is_a($me->auth, Basic::class) ? $me : null;
    }

    /**
     * @return Access|null
     */
    public static function digest()
    {
        $me = new self();
        return is_subclass_of($me->auth, Basic::class) ? $me : null;
    }

    /**
     * @return Access|null
     */
    public static function create()
    {
        return self::basic() ?: self::digest();
    }

    public function validPassword($password)
    {
        return $this->auth ? $this->auth->passwordValid($password) : null;
    }

    public function validHA1($ha1)
    {
        return !method_exists($this->auth, 'ha1Valid') ? null : $this->auth->ha1Valid($ha1);
    }

    public function checkPassword($password)
    {
        if (!$this->validPassword($password)) $this->authFailed('Invalid Password!');
    }

    public function checkHA1($ha1)
    {
        if (!$this->validHA1($ha1)) $this->authFailed('Invalid credentials!');
    }

    public static function authenticateByPassword($password)
    {
        (new self())->checkPassword($password);
    }

    public static function authenticateByHA1($ha1)
    {
        (new self())->checkHA1($ha1);
    }

    private function httpAuthorization()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION']))
            return null;
        if (stripos($_SERVER['HTTP_AUTHORIZATION'], 'basic') === 0) {
            list($username, $password) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
            $basic = new Basic();
            $basic->setPassword($password);
            $basic->setUsername($username);
            return $basic;
        }
        return $this->http_digest_parse(substr($_SERVER['HTTP_AUTHORIZATION'], 8));
    }

    /**
     * @param string|array $txt
     * @return Digest|Digest2617|null
     *
     * @see http://php.net/manual/en/features.http-auth.php
     */
    protected function http_digest_parse($txt)
    {
        // protect against missing data
        $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1,
            'qop' => 1, 'username' => 1, 'uri' => 1,
            'response' => 1, 'opaque' => 1, 'realm' => 1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:(["])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        if ($needed_parts) {
            if (3 === count(array_diff(['nc', 'cnonce', 'qop'], array_keys($data)))) {
                return new Digest($data);
            }
            return null;
        }

        return $needed_parts ? null : new Digest2617($data);
    }

    public function authFailed($message)
    {
        header('HTTP/1.1 401 Unauthorized');
        header('Content-Type: text/html');
        $this->setAutHeader();
        echo $message;
        exit();
    }

}
