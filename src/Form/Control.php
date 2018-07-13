<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\Writer;

abstract class Control implements ControlField
{
    protected $label;
    protected $hint;
    protected $name;
    protected $output;
    protected $attributes = [];
    protected $namespace;
    protected $uri;

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

    protected function labelWrite(Writer $writer)
    {
       if ($this->label) $writer->writeElement('label', $this->label);
    }

    protected function hintWrite(Writer $writer)
    {
        if ($this->hint) $writer->writeElement('hint', $this->hint);
    }

    /**
     * @param Writer $writer
     * @param \Closure|null $closure
     * @return Writer
     */
    protected function write(Writer $writer, $closure = null)
    {
        if ($this->namespace) $writer->startElementNs($this->namespace, static::ELEMENT, $this->uri);
        else $writer->startElement(static::ELEMENT);
        $writer->writeAttribute('ref', $this->name);
        if (!empty($this->attributes)) {
            foreach ($this->attributes as $name => $val) {
                $writer->writeAttribute($name, $val);
            }
        }
        $this->labelWrite($writer);
        $this->hintWrite($writer);
        if (is_callable($closure)) $closure($writer);
        $writer->endElement();
        return $writer;
    }
}