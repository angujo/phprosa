<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\HeadBind;
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
        $this->translations[Args::DEF_LANG][md5($this->label)] = $this->label;
    }

    public function translateLabel($lang, $label)
    {
        $this->translations[$lang][md5($label)] = $label;
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

    protected function labelWrite(Writer $writer)
    {
        if ($this->label) {
            $writer->startElement(Elmt::LABEL);
            $writer->writeAttribute('ref', Itext::jr($this->getLabelPath()));
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


    public function translate()
    {
        foreach ($this->translations as $lang => $translations) {
            foreach ($translations as $id => $translation) {
                Itext::translate($this->getLabelPath(), $translation, $lang);
            }
        }
        $this->translated = TRUE;
    }

}
