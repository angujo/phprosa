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
use Angujo\PhpRosa\Util\Elmt;

class SelectOne extends Select
{
    const ELEMENT = Elmt::SELECT_ONE;

    protected function __construct($label, $n)
    {
        parent::__construct($label, $n);
    }
}