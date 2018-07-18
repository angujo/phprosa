<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-17
 * Time: 7:00 PM
 */

namespace Angujo\PhpRosa\Authentication;


//TODO Work on this

/**
 * Class Digest2617
 * @package Angujo\PhpRosa\Authentication
 */
class Digest2617 extends Digest
{
    private $cnonce;
    private $qop;

    /**
     * @return mixed
     */
    public function getCnonce()
    {
        return $this->cnonce;
    }

    /**
     * @param mixed $cnonce
     * @return Digest2617
     */
    public function setCnonce($cnonce)
    {
        $this->cnonce = $cnonce;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQop()
    {
        return $this->qop;
    }

    /**
     * @param mixed $qop
     * @return Digest2617
     */
    public function setQop($qop)
    {
        $this->qop = $qop;
        return $this;
    }

}