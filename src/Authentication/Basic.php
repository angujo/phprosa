<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-17
 * Time: 6:40 PM
 */

namespace Angujo\PhpRosa\Authentication;


class Basic
{
    protected $password;
    protected $username;

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Basic
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return Basic
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

}