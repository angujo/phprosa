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

    public function __construct(array $details = [])
    {
        foreach ($details as $k => $v) {
            if (property_exists($this, $k)) $this->{$k} = is_string($v) ? trim($v) : $v;
        }
    }

    public function passwordValid($password)
    {
        return strcasecmp($this->password, $password) === 0;
    }

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