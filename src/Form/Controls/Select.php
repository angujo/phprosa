<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:35 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Form\Data;
use Angujo\PhpRosa\Form\ItemNode;
use Angujo\PhpRosa\Form\ItemSet;
use Angujo\PhpRosa\Form\ItemsList;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Util\Elmt;

class Select extends Control
{
    /** @var ItemsList */
    protected $options;
    /** @var ItemSet */
    protected $itemSet;

    const ELEMENT = Elmt::SELECT;

    protected function __construct($label, $n)
    {
        parent::__construct($label, $n);
        $this->options = ItemsList::create();
        $this->type = Data::TYPE_STRING;
        $this->options->setIndexing('opt');
    }

    /**
     * @param ItemSet|string $set_ref
     * @param string $label_pointer
     * @param string $value_pointer
     */
    public function setItemSet($set_ref, $label_pointer = null, $value_pointer = null)
    {
        $label = $label_pointer ?: Elmt::LABEL;
        $value = $value_pointer ?: Elmt::VALUE;
        if (is_object($set_ref)) {
            if (!is_a($set_ref, ItemSet::class)) return;
            $this->itemSet = $set_ref;
            return;
        }
        $this->itemSet = ItemSet::create($set_ref, $value, $label);
    }

    /**
     * @param string $name
     * @param string|int|null $value
     * @return Option|\Angujo\PhpRosa\Form\Item
     */
    public function addOption($name, $value)
    {
        $translatable = null;
        $option = Option::create($name, $value, true, $translatable);
        $option->setDetails($this->id, 'opt' . count($this->options));
        $this->options->addItem($option);
        return $option;
    }

    public function addItem($name, $value)
    {
        return $this->addOption($name, $value);
    }

    public function write(Writer $writer, $closure = null)
    {
        return parent::write($writer, function (Writer $writer) {
            if (!$this->itemSet) {
                $this->options->write($writer, $this->getLabelPath(false));
            } else {
                $this->itemSet->write($writer);
            }
        });
    }

    /**
     * @return ItemsList
     */
    public function getOptions()
    {
        return $this->options;
    }
}