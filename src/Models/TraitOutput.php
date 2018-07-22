<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-16
 * Time: 7:49 PM
 */

namespace Angujo\PhpRosa\Models;


use Angujo\PhpRosa\Core\Writer;

trait TraitOutput
{
    private $_output = false;

    public function response()
    {
        $this->_output = true;
        return $this;
    }

    public function xml()
    {
        $writer = new Writer();
        $this->write($writer);
        if ($this->_output) {
            header('Content-Type: text/xml');
            print $writer->xml();
            exit;
        }
        return $writer->xml();
    }

    public function array_json()
    {
        $arr = method_exists($this, 'json_array') ? $this->json_array() : $this->arrayAccess();
        if ($this->_output) {
            header('Content-Type: application/json;charset:utf-8');
            print json_encode($arr);
            exit;
        }
        return $arr;
    }
}