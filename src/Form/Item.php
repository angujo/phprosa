<?php

/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 4:25 AM
 */

namespace Angujo\PhpRosa\Form;

use Angujo\PhpRosa\Core\TraitArray;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;
use Angujo\PhpRosa\Form\ItemNode;

class Item {

    use TraitArray;

    protected $id;
    protected $itext = 'itextId';
    protected $trans_sfx;

    /** @var ItemNode[] */
    protected $nodes = [];

    protected function __construct($id) {
        $this->id = $id;
        $this->for_array = 'nodes';
        // $this->for_array = ['nodes'];
    }

    public static function create($id, $val = null) {
        return new self($id);
    }
    
    public function setSuffix($sfx) {
        $this->trans_sfx=$sfx;
        return $this;
    }
    
    public function translate($nodeRef) {
        $nodeRef= $this->nodeRef($nodeRef);
        foreach ($this->nodes as $node) {
            $node->translate($nodeRef);
        }
    }
    
    private function nodeRef($ref) {
        return $ref?$ref.($this->trans_sfx?':'.$this->trans_sfx:''):'';
    }

    /**
     * 
     * @param string $name
     * @param string $value
     * @return ItemNode
     */
    public function addNode($name, $value,$translate=false) {
        if (null === $name || null === $value) {
            return NULL;
        }
        $node = ItemNode::create($name, $value,$translate);
        $this->nodes[] = $node;
        return $node;
    }

    public function write(Writer $writer,$nodeRef=null) {
        if (empty($this->nodes))
            return $writer;
        $writer->startElement(Elmt::ITEM);
        if (null !== $this->id)
            $writer->writeElement($this->itext, $this->id);
        $nodeRef= $this->nodeRef($nodeRef);
        foreach ($this->nodes as $node) {
            $node->write($writer, $nodeRef);
        }
        $writer->endElement();
        return $writer;
    }

    /* public function arrayProperties()
      {
      return 'nodes';
      } */
}
