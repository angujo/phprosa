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
    /** @var Digest */
    private $digest;

    public function __construct()
    {

    }

    public function validateBasic(Basic $basic)
    {

    }


    /**
     * @param $txt
     * @return array|bool
     *
     * @see http://php.net/manual/en/features.http-auth.php
     */
    protected function http_digest_parse($txt)
    {
        // protect against missing data
        $needed_parts = array('nonce' => 1, 'nc' => 1, 'cnonce' => 1, 'qop' => 1, 'username' => 1, 'uri' => 1, 'response' => 1);
        $data = array();
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $data[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $data;
    }

    public function digestFailed($message)
    {
        header('HTTP/1.1 401 Unauthorized');
        header('Content-Type: text/html');
        header(sprintf('WWW-Authenticate: Digest realm="%s", nonce="%s", opaque="%s"', $this->digest->getRealm(), $this->digest->getNonce(), $this->digest->getOpaque()));
        echo $message;
        exit();
    }
}