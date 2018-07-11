<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:35 AM
 */

namespace PhpRosa\Form\Controls;


use PhpRosa\Form\Control;
use PhpRosa\Form\ItemsList;

class Select extends Control
{
    /** @var ItemsList */
    protected $options;
    const ELEMENT = 'select';

    protected function __construct($label, $n)
    {
        parent::__construct($label, $n);
        $this->options = ItemsList::create('choices');
    }

    public function addOption($name, $value)
    {
        $this->options->addItem(Option::create($name, $value));
        return $this;
    }

    public function xml(\XMLWriter $writer)
    {
        return parent::xml($writer, function (\XMLWriter $writer) {
            $this->options->xml($writer);
        });
    }
}