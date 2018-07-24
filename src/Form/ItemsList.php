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

class ItemsList extends Iteration {

    use TraitArray;

    private $root;
    private $indexing;

    private function __construct($root) {
        $this->root = $root;
    }

    public static function create($root = null) {
        return new self($root);
    }

    public function addItem(Item $item) {
        $this->list[] = $item;
        return $item;
    }

    public function nullifyRoot() {
        $this->root = null;
        return $this;
    }

    public function setIndexing($prefix) {
        $this->indexing = $prefix;
        return $this;
    }

    /**
     * 
     * @param Writer $writer
     * @return Writer
     */
    public function write(...$args) {
        if (empty($this->list)) {
            return $args[0];
        }
        return $this->wrap($args[0], function (Writer $writer) use($args) {
                    $s = 0;
                    foreach ($this->list as $item) {
                        /** @var Item $item */
                        if (method_exists($item, 'write')) {
                            if ($this->indexing) {
                                $item->setSuffix($this->indexing . $s);
                                $s++;
                            }
                            call_user_func_array([$item, 'write'], $args);
                        }
                    }
                });
    }

    private function wrap(Writer $writer, \Closure $closure) {
        if ($this->root) {
            $writer->startElement($this->root);
            $closure($writer);
            $writer->endElement();
        } else {
            $closure($writer);
        }
        return $writer;
    }

}
