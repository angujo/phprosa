<?php

/*
 * PhpRosa: Php for OpenRosa
 * MIT license * 
 */

namespace Angujo\PhpRosa\Core;

/**
 * Description of Path
 *
 * @author bangujo
 */
class Path
{

    /** @var string */
    private $name;
    /** @var array */
    private $xpath = [];
    /** @var string */
    private $root;
    /** @var string */
    private $id;
    /** @var bool */
    private $ignored = false;
    /** @var null|string */
    private $value;

    protected function __construct($id)
    {
        $this->id = $id;
    }

    public static function create($id, $name)
    {
        return (new self($id))->setName($name);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    public function append($path)
    {
        if (\is_array($path))
            $this->xpath = array_merge($this->xpath, $path);
        elseif (\is_string($path))
            $this->xpath[] = $path;
        return $this;
    }

    public function prepend($path)
    {
        if (\is_array($path))
            $this->xpath = array_merge($path, $this->xpath);
        elseif (\is_string($path))
            array_unshift($this->xpath, $path);
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setRoot($root)
    {
        $this->root = $root;
        return $this;
    }

    public function xPath()
    {
        $paths = $this->xpath;
        array_unshift($paths, $this->root);
        return implode('/', $paths);
    }

    public function fullPath()
    {
        $paths = $this->xpath;
        array_unshift($paths, $this->root);
        $paths[] = $this->name;
        return implode('/', $paths);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getXpath(): array
    {
        $paths = $this->xpath;
        array_unshift($paths, $this->root);
        return $paths;
    }

    public function fullXPath()
    {
        $paths = $this->getXpath();
        $paths[] = $this->name;
        return $paths;
    }

    /**
     * @return array
     */
    public function rootXPath()
    {
        $paths = $this->xpath;
        $paths[] = $this->name;
        return $paths;
    }

    /**
     * @param bool $ignored
     * @return Path
     */
    public function setIgnored(bool $ignored): Path
    {
        $this->ignored = $ignored;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIgnored(): bool
    {
        return $this->ignored;
    }

    /**
     * @param mixed $value
     * @return Path
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
