<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PhpRosa\Models;

/**
 *
 * @author bangujo
 */
trait TraitGenerator {

    /**
     * 
     * @param \XMLWriter $xmlWriter
     * @return \XMLWriter
     */
    public function xml(\XMLWriter $xmlWriter) {
        $vars = get_object_vars($this);
        $xmlWriter->startElement($this->root);
        foreach ($vars as $property => $value) {
            if (null === $value || strcasecmp('root', $property) === 0)
                continue;
            $xmlWriter->startElement($property);
            $xmlWriter->text($value);
            $xmlWriter->endElement();
        }
        $xmlWriter->endElement();
        return $xmlWriter;
    }
    
    public function __set($name,$value) {
        throw new \RuntimeException('Setting properties not allowed!');
    }
    
    

}
