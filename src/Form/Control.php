<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace PhpRosa\Form;


abstract class Control
{
    protected $label;
    protected $hint;
    protected $name;
    protected $output;
    protected $attributes=[];

    const ELEMENT = 'control';

    protected function __construct($label, $name)
    {
        $this->label = $label;
        $this->name = $name;
    }

    public static function create($label, $name)
    {
        return new static($label, $name);
    }

    protected function labelXml(\XMLWriter $writer)
    {
        $writer->writeElement('label', $this->label);
    }

    protected function hintXml(\XMLWriter $writer)
    {
        if ($this->hint) $writer->writeElement('hint', $this->hint);
    }

    /**
     * @param \XMLWriter $writer
     * @param \Closure|null $closure
     * @return \XMLWriter
     */
    protected function xml(\XMLWriter $writer, $closure = null)
    {
        $writer->startElement(static::ELEMENT);
        $writer->writeAttribute('ref', $this->name);
        if (!empty($this->attributes)){
            foreach ($this->attributes as $name => $val) {
                $writer->writeAttribute($name,$val);
            }
        }
        $this->labelXml($writer);
        if (is_callable($closure)) $closure($writer);
        $writer->endElement();
        return $writer;
    }
}