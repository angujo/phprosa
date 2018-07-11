<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace PhpRosa\Form\Controls;


use PhpRosa\Form\Control;

class Input extends Control
{
    const ELEMENT = 'input';


    public function xml(\XMLWriter $writer)
    {
        return parent::xml($writer, function (\XMLWriter $writer) {
            $this->hintXml($writer);
        });
    }
}