<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 4:30 AM
 */

namespace PhpRosa\Form;


use PhpRosa\Util\Iteration;

class ItemsList extends Iteration
{
    private $root = 'root';

    private function __construct($root)
    {
        $this->root = $root;
    }

    public static function create($root)
    {
        return new self($root);
    }

    public function addItem(Item $item)
    {
        $this->list[] = $item;
    }

    public function xml(\XMLWriter $writer)
    {
        if (empty($this->list)) return $writer;
        if (null !== $this->root) $writer->startElement($this->root);
        foreach ($this->list as $item) {
            $item->xml($writer);
        }
        if (null !== $this->root) $writer->endElement();
        return $writer;
    }
}