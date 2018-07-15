<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:27 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Form\Item;

class Option extends Item
{
    const LABEL = 'label';
    const VALUE = 'value';

    public static function create($name, $value=null)
    {
        $me = new self(null);
        $me->addNode(self::LABEL, $name);
        $me->addNode(self::VALUE, $value);
        return $me;
    }
}