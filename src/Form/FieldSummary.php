<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-10
 * Time: 6:41 PM
 */

namespace PhpRosa\Form;


class FieldSummary implements FieldInterface
{
    private $name;
    private $default_value;

    private function __construct($n, $v)
    {
        $this->name = $n;
        $this->default_value = $v;
    }

    public static function create($name, $value = null)
    {
        return new self($name, $value);
    }

    public function xml(\XMLWriter $writer)
    {
        $writer->startElement($this->name);
        if (null !== $this->default_value) $writer->text($this->default_value);
        $writer->endElement();
        return $writer;
    }
}