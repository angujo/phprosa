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
    private $auth;

    public function __construct()
    {
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $this->auth = new Basic(['username' => $_SERVER['PHP_AUTH_USER'], 'password' => $_SERVER['PHP_AUTH_PW']]);
        } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
            $this->auth = $this->http_digest_parse($_SERVER['PHP_AUTH_DIGEST']);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $this->auth = $this->httpAuthorization();
        }
        if (null === $this->auth || !is_subclass_of($this->auth, Basic::class) || !is_a($this->auth, Basic::class)) {
            header('HTTP/1.0 401 Missing Authorization');
            echo 'Authorization identification missing!';
            die;
        }
    }

    private function httpAuthorization()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) return null;
        if (stripos($_SERVER['HTTP_AUTHORIZATION'], 'basic') === 0) {
            list($username, $password) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
            $basic = new Basic();
            $basic->setPassword($password);
            $basic->setUsername($username);
            return $basic;
        }
        return $this->http_digest_parse(substr($_SERVER['HTTP_AUTHORIZATION'], 8));
    }

    public function validateBasic(Basic $basic)
    {

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

    public function digestFailed($message)
    {
        header('HTTP/1.1 401 Unauthorized');
        header('Content-Type: text/html');
        header(sprintf('WWW-Authenticate: Digest realm="%s", nonce="%s", opaque="%s"', $this->auth->getRealm(), $this->auth->getNonce(), $this->auth->getOpaque()));
        echo $message;
        exit();
    }
}