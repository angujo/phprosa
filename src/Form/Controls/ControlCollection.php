<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-12
 * Time: 8:59 PM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Core\Attribute;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Form\ControlField;
use Angujo\PhpRosa\Util\Strings;

abstract class ControlCollection implements GroupRepeat
{
    public    $id;
    protected $no_repeat = false;

    protected $label;
    /** @var ControlField[]|ControlCollection[] */
    protected $controls = [];
    /** @var GroupRepeat */
    protected $parent;
    /** @var Attribute[] */
    protected $attributes = [];
    const ELEMENT = 'collector';
    protected $xpath = [];
    private   $name;

    protected function __construct($ref, $label)
    {
        // if ($ref) $this->attributes[] = new Attribute('ref', $ref);
        $this->name = $ref ?: 'group_'.Strings::random('a',8,true);
        $this->xpath[] = $this->name;
        $this->label = $label;
        $this->id = uniqid('id', false);
    }

    public static function create($ref = null, $label = null)
    {
        return new static($ref, $label);
    }

    public function addControl(Control $control)
    {
        $control->setXpath($this->xpath);
        $this->controls[] = &$control;
        return $this;
    }

    public function addGroup(ControlCollection $repeat)
    {
        /** Ensure NO nested repeat elements */
        if ($this->no_repeat && strcmp($repeat::ELEMENT, Repeat::ELEMENT) === 0) return $this;
        $repeat->setNoRepeat($this->no_repeat || strcmp($repeat::ELEMENT, Repeat::ELEMENT) === 0);
        $repeat->setParent($this);
        $repeat->setXpath($this->xpath);
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

    /**
     * @param Writer $writer
     */
    public function write(Writer $writer)
    {
        $writer->startElement(static::ELEMENT);
        foreach ($this->attributes as $attribute) {
            $writer->addAttribute($attribute);
        }
        if ($this->label) $writer->writeElement('label', $this->label);
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
        $this->xpath = array_merge($this->xpath, $xpath);
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