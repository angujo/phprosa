<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 4:25 AM
 */

namespace PhpRosa\Form;


class Item
{
    private $id;
    private $itext = 'itextId';
    private $nodes = [];

    protected function __construct($id)
    {
        $this->id = $id;
    }

    public static function create($id)
    {
        return new self($id);
    }

    public function addNode($name, $value)
    {
        if (null === $name || null === $value) return;
        $this->nodes[$name] = $value;
    }

    public function xml(\XMLWriter $writer)
    {
        if (empty($this->nodes)) return $writer;
        $writer->startElement('item');
        if (null !== $this->id) $writer->writeElement($this->itext, $this->id);
        foreach ($this->nodes as $name => $value) {
            $writer->writeElement($name, $value);
        }
        $writer->endElement();
        return $writer;
    }
}