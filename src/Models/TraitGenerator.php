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

    /**
     *
     * @param Writer $xmlWriter
     * @return Writer
     */
    public function write(Writer $xmlWriter)
    {
        $vars = get_object_vars($this);
        $xmlWriter->startElement($this->root);
        foreach ($vars as $var => $val) {
            if (false===strpos($var,'_') || (false!==strpos($var,'_') && !is_string($val))) continue;
            $xmlWriter->writeAttribute(ltrim($var,'_'),$val);
        }
        foreach ($vars as $property => $value) {
            if (null === $value || strcasecmp('root', $property) === 0 || false!==strpos($property,'_'))
                continue;
            if (is_array($value) && !empty($value)) {
                //var_dump(array_keys($value));die;
                foreach ($value as $item) {
                    if (!is_object($item) || (is_object($item) && (!method_exists($item, 'xml') || !is_callable([$item, 'xml'], false)))){
                        continue;
                    }
                    $item->xml($xmlWriter);
                }
                continue;
            }
            $xmlWriter->writeElement($property,$value);
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
        throw new \RuntimeException('Setting properties not allowed!');
    }

    public function __get($name)
    {
        throw new \RuntimeException('Not allowed!');
    }

    public function __isset($name)
    {
        return property_exists($this, $name);
    }


}
