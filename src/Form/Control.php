<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\Writer;

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

    protected function labelwrite(Writer $writer)
    {
        $writer->writeElement('label', $this->label);
    }

    protected function hintwrite(Writer $writer)
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
        $writer->startElement(static::ELEMENT);
        $writer->writeAttribute('ref', $this->name);
        if (!empty($this->attributes)){
            foreach ($this->attributes as $name => $val) {
                $writer->writeAttribute($name,$val);
            }
        }
        $this->labelwrite($writer);
        if (is_callable($closure)) $closure($writer);
        $writer->endElement();
        return $writer;
    }
}