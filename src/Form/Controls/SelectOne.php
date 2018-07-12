<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:33 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Form\ItemsList;

class SelectOne extends Select
{
    const ELEMENT = 'select1';

    protected function __construct($label,$n)
    {
        parent::__construct($label,$n);
        $this->options = ItemsList::create(null);
    }
}