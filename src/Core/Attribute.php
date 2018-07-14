<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:53 PM
 */

namespace Angujo\PhpRosa\Core;


use Angujo\PhpRosa\Core\Writer;

class Attribute extends XMLElement
{
    private $element;

    /**
     * @return Element
     */
    public function getElement()
    {
        if (!isset(Session::$elements[$this->element])) return null;
        return Session::$elements[$this->element];
    }

    /**
     * @param Element $element
     * @return Attribute
     */
    public function setElement(Element $element)
    {
        $this->element = $element->id;
        return $this;
    }

    public function xml(\XMLWriter $writer)
    {
        if ($this->namespace) {
            $writer->writeAttributeNS($this->namespace, $this->name, $this->namespace_path, $this->content);
            return $writer;
        }
        $writer->writeAttribute($this->name, $this->content);
        return $writer;
    }

}