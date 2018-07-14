<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\Writer;

/**
 * Class Control
 * @package Angujo\PhpRosa\Form
 *
 * @property $readonly
 * @property $required
 * @property $relevant
 * @property $constraint
 * @property $calculate
 * @property $save_incomplete
 * @property $required_msg
 * @property $constraint_msg
 * @property $preload
 * @property $preload_params
 * @property $max_pixels
 */
abstract class Control implements ControlField
{
    protected $label;
    protected $hint;
    protected $name;
    protected $output;
    protected $attributes = [];
    protected $namespace;
    protected $uri;

    /** @var Bind */
    protected $binding;

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

    /**
     * @return Bind
     */
    public function getBinding()
    {
        return $this->binding;
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
    public function write(Writer $writer, $closure = null)
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

    /*
     * Below we'll extend the Bind for the control
     */

    /**
     * @param $property
     * @param $value
     */
    public function __set($property, $value)
    {
        if (!$this->binding) {
            $this->binding = new Bind();
            $this->binding->nodeset = $this->name;
        }
        $this->binding->{$property} = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->binding && isset($this->binding->{$name});
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (!$this->binding) return null;
        return $this->binding->{$name};
    }
}