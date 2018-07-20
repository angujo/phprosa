<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-17
 * Time: 6:41 PM
 */

namespace Angujo\PhpRosa\Authentication;


class Digest extends Basic
{
    use TraitAuth;

    protected $nonce;
    protected $opaque;
    protected $realm;
    protected $uri;
    protected $response;

    private   $a1;
    private   $a2;
    protected $request_method;


    /**
     * @return mixed
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @param mixed $nonce
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
    }

    /**
     * @return mixed
     */
    public function getOpaque()
    {
        return $this->opaque;
    }

    /**
     * @param mixed $opaque
     */
    public function setOpaque($opaque)
    {
        $this->opaque = $opaque;
    }

    /**
     * @return mixed
     */
    public function getRealm()
    {
        return $this->realm;
    }

    /**
     * @param mixed $realm
     */
    public function setRealm($realm)
    {
        $this->realm = $realm;
    }

    /**
     * @return mixed
     */
    protected function getA1()
    {
        return "$this->username:$this->realm:$this->password";
    }

    public function passwordValid($password)
    {
        return 0 === strcasecmp($this->genPassWH1($password), $this->getHA2());
    }

    public function ha1Valid($ha1)
    {
        return 0 === strcasecmp($ha1, $this->getHA1());
    }

    /**
     * @return mixed
     */
    protected function getA2()
    {
        return "$this->request_method:$this->uri";
    }

    protected function getHA1()
    {
        return md5($this->getA1());
    }

    protected function genPassWH1($password)
    {
        return md5("$this->username:$this->realm:$password");
    }

    protected function getHA2()
    {
        return md5($this->getA2());
    }

    /**
     * @param mixed $uri
     * @return Digest
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return mixed
     */
    protected function getResponse()
    {
        return $this->response ?: md5($this->getHA1() . ':' . $this->getNonce() . ':' . $this->getHA2());
    }


}