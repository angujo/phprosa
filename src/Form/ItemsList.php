<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 4:30 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Util\Iteration;
use Angujo\PhpRosa\Core\Writer;

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

    public function write(Writer $writer)
    {
        if (empty($this->list)) return $writer;
        if (null !== $this->root) $writer->startElement($this->root);
        foreach ($this->list as $item) {
            $item->write($writer);
        }
        if (null !== $this->root) $writer->endElement();
        return $writer;
    }
}