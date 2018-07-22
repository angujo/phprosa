<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-22
 * Time: 10:23 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Util\Elmt;

class TranslationItem
{
    private $id;
    private $value;

    protected function __construct($id, $val)
    {
        $this->id = $id;
        $this->value = $val;
    }

    public static function create($id, $value)
    {
        return new self($id, $value);
    }

    public function write(Writer $writer)
    {
        $writer->startElement(Elmt::TEXT);
        $writer->writeAttribute('id', $this->id);
        $writer->writeElement(Elmt::VALUE, $this->value);
        $writer->endElement();
        return $writer;
    }
}