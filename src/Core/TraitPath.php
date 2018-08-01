<?php

/*
 * PhpRosa: Php for OpenRosa
 * MIT license *
 */

namespace Angujo\PhpRosa\Core;

use Angujo\PhpRosa\Util\Elmt;

/**
 * Description of TraitPath
 *
 * @author bangujo
 */
trait TraitPath
{
    /**
     * Unique path identifier for the element.
     * @var string|int
     */
    private $id;

    /**
     * @param string $name
     * @return TraitPath
     */
    public function setName($name)
    {
        IdPath::getPath($this->id)->setName($name);
        return $this;
    }

    public function getXPath()
    {
        return IdPath::getPath($this->id)->getXpath();
    }

    public function getRef()
    {
        return '/'.IdPath::getPath($this->id)->fullPath();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return IdPath::getPath($this->id)->getName();
    }

    /**
     * @param $path
     * @return $this
     */
    public function addXPath($path)
    {
        IdPath::getPath($this->id)->append($path);
        return $this;
    }

    /**
     * @param $path
     * @return $this
     */
    public function shiftXPath($path)
    {
        IdPath::getPath($this->id)->prepend($path);
        return $this;
    }

    /**
     * @param $root
     * @return $this
     */
    public function setRoot($root)
    {
        IdPath::getPath($this->id)->setRoot($root);
        return $this;
    }

    protected function ignore()
    {
        IdPath::getPath($this->id)->setIgnored(true);
        return $this;
    }

    /**
     * @return array
     */
    public function rootPath()
    {
        return IdPath::getPath($this->id)->rootXPath();
    }

    /**
     * @param bool $label
     * @return string
     */
    public function getLabelPath($label = true)
    {
        return $this->getRef() . ($label ? ':' . Elmt::LABEL : '');
    }

    protected function pathValue($value)
    {
        IdPath::getPath($this->id)->setValue($value);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return IdPath::getPath($this->id)->getValue();
    }

}
