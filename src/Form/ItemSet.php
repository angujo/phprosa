<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-12
 * Time: 7:24 PM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\Writer;

class ItemSet
{
    private $name;
    private $value;
    private $label;
    private $random = false;

    private function __construct($ref, $value_ref, $label_ref)
    {
        $this->name = $ref;
        $this->value = $value_ref;
        $this->label = $label_ref;
    }

    public static function create($ref, $value_ref = 'value', $label_ref = 'label')
    {
        return new self($ref, $value_ref, $label_ref);
    }

    public function randomize($yes = false)
    {
        $this->random = $yes;
        return $this;
    }

    public function write(Writer $writer)
    {
        $writer->startElement('itemset');
        $writer->writeAttribute('nodeset', $this->name);
        $writer->startElement('value');
        $writer->writeAttribute('ref', $this->value);
        $writer->endElement();
        $writer->startElement('label');
        $writer->writeAttribute('ref', $this->label);
        $writer->endElement();
        $writer->endElement();
        return $writer;
    }
}