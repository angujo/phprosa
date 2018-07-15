<?php
/**
 * Created for phprosa.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:31 PM
 */

namespace Angujo\PhpRosa\Core;


class Writer
{
    /** @var Element */
    private $active;
    /** @var Attribute */
    private $attribute;

    /** @var Element */
    private $root;

    public function __construct() { }

    public function text($content)
    {
        if (!$this->attribute && !$this->active) return false;
        if ($this->attribute) $this->attribute->setContent($content);
        else $this->active->setContent($content);
        return true;
    }

    public function writeAttribute($name, $content)
    {
        return $this->writeAttributeNs(null, $name, null, $content);
    }

    public function writeAttributeNs($prefix, $name, $uri, $content)
    {
        if (!$this->startAttributeNs($prefix, $name, $uri)) return false;
        $this->text($content);
        return $this->endAttributeNs();
    }

    public function writeElementNs($prefix, $name, $uri, $content)
    {
        if (!$this->startElementNs($prefix, $name, $uri)) return false;
        $this->text($content);
        return $this->endElementNs();
    }

    public function writeElement($name, $content)
    {
        return $this->writeElementNs(null, $name, null, $content);
    }

    public function startAttribute($name)
    {
        return $this->startAttributeNs(null, $name, null);
    }

    public function endAttribute()
    {
        return $this->endAttributeNs();
    }

    public function addAttribute(Attribute $attribute)
    {
        if (!$this->attribute || !$this->active) return false;
        $this->active->addAttribute($attribute);
        $this->attribute = null;
        return true;
    }

    public function startAttributeNs($prefix, $name, $uri)
    {
        if (!$this->active || $this->attribute) false;
        $this->attribute = new Attribute($name, $prefix, $uri);
        if ($prefix && $uri) $this->setNamespace($this->active->id, $prefix, $uri);
        return true;
    }

    public function endAttributeNs()
    {
        return $this->addAttribute($this->attribute);
    }

    public function startElement($name)
    {
        return $this->startElementNs(null, $name, null);
    }

    public function startElementNs($prefix, $name, $uri)
    {
        $element = new Element($name, $prefix, $uri);
        if ($prefix && $uri) $this->setNamespace($element->id, $prefix, $uri);
        if ($this->active) {
            $this->active->addElement($element);
            $element->setParent($this->active);
        }
        $this->active = $element;
        Session::$elements[$this->active->id] = $this->active;
        if (!$this->root) $this->root = $this->active;
        return true;
    }

    public function endElementNs()
    {
        return $this->endElement();
    }

    public function endElement()
    {
        if ($this->active) {
            $this->active = $this->active->getParent();
            return true;
        }
        return false;
    }

    public function xml()
    {
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument();
        $this->toXml($writer);
        $writer->endDocument();

        return $writer->outputMemory(TRUE);
    }

    public function json_array()
    {
        if (!$this->root) return [];
        return $this->root->json_array();
    }

    private function toXml(\XMLWriter $writer)
    {
        if (!$this->root) return;
        $this->root->xml($writer);
    }

    private function setNamespace($id, $prefix, $uri, $holder = false)
    {
        if (empty(Session::$xml_namespaces) || $holder) {
            Session::$active_holder = $id;
        }
        Session::$xml_namespaces[Session::$active_holder][$prefix] = $uri;
    }
}