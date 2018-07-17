<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Angujo\PhpRosa\Models;

use Angujo\PhpRosa\Core\Writer;

/**
 *
 * @author bangujo
 */
trait TraitGenerator
{
    protected $attributes = [];
    protected $children   = [];

    /**
     *
     * @param Writer $xmlWriter
     * @return Writer
     */
    public function write(Writer $xmlWriter)
    {
        $xmlWriter->startElement(self::ELEMENT);
        foreach ($this->attributes as $attribute) {
            if (null === $this->{$attribute} || array_key_exists($attribute,$this->children)) continue;
            $xmlWriter->writeAttribute($attribute, $this->{$attribute});
        }
        foreach ($this->children as $key => $child) {
            if (is_object($child) && method_exists($child, 'write') && is_callable([$child, 'write'])) {
                $child->write($xmlWriter);
            } else {
                $xmlWriter->writeElement($key, $child);
            }
        }
        $xmlWriter->endElement();
        return $xmlWriter;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->attributes, false)) {
            $this->children[$name] = $value;
            return;
        }
        throw new \RuntimeException('Setting invalid properties not allowed!');
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->children)) {
            return $this->children[$name];
        }
        if (in_array($name, $this->attributes, false)) return null;
        throw new \RuntimeException("Property '$name' Not found!");
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->children) || property_exists($this, $name);
    }


}
