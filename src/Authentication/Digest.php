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
    private $nonce;
    private $opaque;
    private $realm;

    private $a1;
    private $a2;
    private $request_method;
    private $uri;
    private $response;

    public function __construct($method = null)
    {
        $this->request_method = $method ?: $_SERVER['REQUEST_METHOD'];
    }

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
    public function getA1()
    {
        return $this->a1 ?: md5("$this->username:$this->realm:$this->password");
    }

    /**
     * @return mixed
     */
    public function getA2()
    {
        return $this->a2 ?: md5("$this->request_method:$this->uri");
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
    public function getResponse()
    {
        return $this->response ?: md5($this->getA1() . ':' . $this->nonce . ':' . $this->getA2());
    }


}