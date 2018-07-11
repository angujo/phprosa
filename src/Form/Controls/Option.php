<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:27 AM
 */

namespace PhpRosa\Form\Controls;


use PhpRosa\Form\Item;

class Option extends Item
{
    public static function create($name, $value)
    {
        $me = new self(null);
        $me->addNode('label', $name);
        $me->addNode('value', $value);
        return $me;
    }
}