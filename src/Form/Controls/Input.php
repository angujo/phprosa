<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Core\Writer;

class Input extends Control
{
    const ELEMENT = 'input';


    public function write(Writer $writer)
    {
        return parent::write($writer, null);
    }
}