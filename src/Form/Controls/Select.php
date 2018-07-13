<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:35 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Form\ItemsList;
use Angujo\PhpRosa\Core\Writer;

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

    public function addItem($name, $value)
    {
        return $this->addOption($name, $value);
    }

    public function write(Writer $writer)
    {
        return parent::write($writer, function (Writer $writer) {
            $this->options->write($writer);
        });
    }
}