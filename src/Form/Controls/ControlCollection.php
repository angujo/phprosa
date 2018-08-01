<?php

/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-12
 * Time: 8:59 PM
 */

namespace Angujo\PhpRosa\Form\Controls;

use Angujo\PhpRosa\Core\Attribute;
use Angujo\PhpRosa\Core\TraitArray;
use Angujo\PhpRosa\Core\TraitPath;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Form\ControlField;
use Angujo\PhpRosa\Form\TraitBind;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;
use Angujo\PhpRosa\Util\Strings;
use Angujo\PhpRosa\Form\Itext;

abstract class ControlCollection implements GroupRepeat
{

    use TraitArray, TraitBind, TraitPath;

    protected $no_repeat = false;
    protected $label;

    /** @var ControlField[]|ControlCollection[] */
    protected $controls = [];

    /** @var ControlCollection */
    protected $parent;

    /** @var Attribute[] */
    protected $attributes   = [];
    protected $appearance;
    protected $translations = [];
    protected $translated   = false;

    const ELEMENT = 'collector';

    protected function __construct($ref, $label)
    {
        // if ($ref) $this->attributes[] = new Attribute('ref', $ref);
        $this->setName($ref ?: 'group_' . Strings::random('a', 8, true));
        $this->ignore();
        $this->label = $label;
        $this->translations[Args::DEF_LANG] = $this->label;
        $this->for_array = ['label', 'binding', 'xpath', 'attributes', 'controls'];
        $this->type = static::ELEMENT;
    }

    public function addTranslation($label, $lang)
    {
        $this->translations[$lang] = $label;
        return $this;
    }

    public function translate()
    {
        foreach ($this->translations as $lang => $translation) {
            Itext::translate($this->getRef() . ':' . Elmt::LABEL, $translation, $lang);
        }
        $this->translated = TRUE;
        foreach ($this->controls as $control) {
            $control->translate();
        }
    }

    public static function create($ref = null, $label = null)
    {
        return new static($ref, $label);
    }

    public function addControl(Control $control)
    {
        $control->shiftXPath($this->rootPath());
        $this->controls[] = &$control;
        return $this;
    }

    public function addGroup(ControlCollection $repeat)
    {
        /** Ensure NO nested repeat elements */
        if ($this->no_repeat && strcmp($repeat::ELEMENT, Repeat::ELEMENT) === 0)
            return $this;
        $repeat->setNoRepeat($this->no_repeat || strcmp($repeat::ELEMENT, Repeat::ELEMENT) === 0);
        $repeat->setParent($this);
        $repeat->shiftXPath($this->getXPath());
        $this->controls[] = &$repeat;
        return $this;
    }

    /**
     * @return GroupRepeat
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param GroupRepeat $parent
     */
    public function setParent(GroupRepeat $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param bool $no_repeat
     * @return ControlCollection
     */
    public function setNoRepeat($no_repeat)
    {
        $this->no_repeat = (bool)$no_repeat;
        return $this;
    }

    public function singleScreen()
    {
        $this->appearance = 'field-list';
        return $this;
    }

    /**
     * @param Writer $writer
     */
    public function write(Writer $writer)
    {
        $writer->startElement(static::ELEMENT);
        foreach ($this->attributes as $attribute) {
            $writer->addAttribute($attribute);
        }
        if (0 === strcmp(Elmt::REPEAT, static::ELEMENT)) {
            $writer->writeAttribute('nodeset', $this->getRef());
        }
        if ($this->appearance) {
            $writer->writeAttribute('appearance', $this->appearance);
        }
        if ($this->label) {
            if (!$this->translated)
                $writer->writeElement(Elmt::LABEL, $this->label);
            else {
                $writer->startElement(Elmt::LABEL);
                $writer->writeAttribute('ref', Itext::jr($this->getRef() . ':' . Elmt::LABEL));
                $writer->endElement();
            }
        }
        foreach ($this->controls as $control) {
            $control->write($writer);
        }
        $writer->endElement();
    }

    /**
     * @param array $xpath
     * @return ControlCollection
     */
    public function setXpath(array $xpath)
    {
        $this->xpath = $xpath;
        return $this;
    }

    /**
     * @return Control[]|ControlCollection[]
     */
    public function getControls()
    {
        return $this->controls;
    }

}
