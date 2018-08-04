<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\HeadBind;
use Angujo\PhpRosa\Core\Language;
use Angujo\PhpRosa\Core\TraitArray;
use Angujo\PhpRosa\Core\TraitPath;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

/**
 * Class Control
 * @package Angujo\PhpRosa\Form
 */
abstract class Control implements ControlField
{
    use TraitArray, TraitBind, TraitPath;

    protected $label;
    protected $hint;
    protected $output;
    protected $attributes   = [];
    protected $namespace;
    protected $uri;
    protected $translations = [];
    protected $translated   = false;

    const ELEMENT = 'control';

    protected function __construct($label, $name)
    {
        $this->label = $label;
        $this->setName($name);
        if (Language::translatable($this->label)) Language::suffixedPath($this->id, $label, Elmt::LABEL);
    }

    public function translateLabel($lang, $label)
    {
        if (Language::translatable($this->label)) Language::suffixedPath($this->id, $label, Elmt::LABEL, $lang);
        return $this;
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
        return HeadBind::getBind($this->id);
    }

    /**
     * LabelXML writer
     * @method labelWrite
     * @param  Writer $writer [description]
     */
    protected function labelWrite(Writer $writer)
    {
        if ($this->label) {
            $writer->startElement(Elmt::LABEL);
            if (Language::translatable($this->label)) $writer->writeAttribute('ref', Itext::jr($this->getLabelPath()));
            else $writer->text($this->label);
            $writer->endElement();
        }
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
        $writer->writeAttribute('ref', $this->getRef());
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


    /**
     * @param mixed $default_value
     * @return Control
     */
    public function setDefaultValue($default_value)
    {
        return $this->pathValue($default_value);
    }

}
