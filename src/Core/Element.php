<?php
/**
 * Created for phprosa.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:36 PM
 */

namespace Angujo\PhpRosa\Core;


use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;

class Element extends XMLElement
{
    private $parent;
    /** @var array */
    private $children = [];
    /** @var Attribute[] */
    private $attributes = [];

    public function addElement(self $element)
    {
        $this->children[] = $element->id;
        return $this;
    }

    /**
     * @return Element[]
     */
    public function getChildren()
    {
        return array_filter(array_map(function ($child) { return isset(Session::$elements[$child]) ? Session::$elements[$child] : null; }, $this->children));
    }

    /**
     * @param Attribute $attribute
     * @return $this
     */
    public function addAttribute(Attribute $attribute)
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    /**
     * @return Attribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return Element|null
     */
    public function getParent()
    {
        if (!isset(Session::$elements[$this->parent])) return null;
        return Session::$elements[$this->parent];
    }

    /**
     * @param Element $parent
     * @return Element
     */
    public function setParent(Element $parent)
    {
        $this->parent = $parent->id;
        return $this;
    }

    public function xml(\XMLWriter $writer)
    {
        parent::preXml($this->attributes);
        if (empty($this->children) && empty($this->attributes)) {
            if ($this->namespace) {
                $writer->writeElementNS($this->namespace, $this->name, $this->namespace_path, $this->content);
            } else $writer->writeElement($this->name, $this->content);
            return $writer;
        }
        if ($this->namespace) $writer->startElementNS($this->namespace, $this->name, $this->namespace_path);
        else $writer->startElement($this->name);
        foreach ($this->attributes as $attribute) {
            $attribute->xml($writer);
        }
        if (!empty($this->children)) {
            $elements = $this->getChildren();
            foreach ($elements as $element) {
                $element->xml($writer);
            }
        } elseif ($this->content) {
            $writer->text($this->content);
        }
        $writer->endElement();
        return $writer;
    }
}