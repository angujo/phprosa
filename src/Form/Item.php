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
use Angujo\PhpRosa\Util\Elmt;

class Item
{
    use TraitArray;
    private $id;
    private $itext = 'itextId';
    private $nodes = [];

    protected function __construct($id)
    {
        $this->id = $id;
        $this->for_array='nodes';
       // $this->for_array = ['nodes'];
    }

    public static function create($id, $val = null)
    {
        return new self($id);
    }

    public function addNode($name, $value)
    {
        if (null === $name || null === $value) return;
        $this->nodes[$name] = $value;
    }

    public function write(Writer $writer)
    {
        if (empty($this->nodes)) return $writer;
        $writer->startElement(Elmt::ITEM);
        if (null !== $this->id) $writer->writeElement($this->itext, $this->id);
        foreach ($this->nodes as $name => $value) {
            $writer->writeElement($name, $value);
        }
        $writer->endElement();
        return $writer;
    }

   /* public function arrayProperties()
    {
        return 'nodes';
    }*/
}