<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 4:30 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\TraitArray;
use Angujo\PhpRosa\Util\Iteration;
use Angujo\PhpRosa\Core\Writer;

class ItemsList extends Iteration
{
    use TraitArray;
    private $root;

    private function __construct($root)
    {
        $this->root = $root;
    }

    public static function create($root = null)
    {
        return new self($root);
    }

    public function addItem(Item $item)
    {
        $this->list[] = $item;
    }

    public function nullifyRoot()
    {
        $this->root = null;
        return $this;
    }

    public function write(Writer $writer)
    {
        if (empty($this->list)) return $writer;
        return $this->wrap($writer, function (Writer $writer) {
            foreach ($this->list as $item) {
                /** @var Item $item */
                $item->write($writer);
            }
        });
    }

    private function wrap(Writer $writer, \Closure $closure)
    {
        if ($this->root) {
            $writer->startElement($this->root);
            $closure($writer);
            $writer->endElement();
        } else $closure($writer);
        return $writer;
    }

}