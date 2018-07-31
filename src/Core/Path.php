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
class Path {

    private $name;
    private $xpath = [];
    private $root;
    private $id;

    protected function __construct($id) {
        $this->id = $id;
    }

    public static function create($id, $name) {
        return (new self($id))->setName($name);
    }
    
    public function getId() {
        return $this->id;
    }

    public function append($path) {
        if (is_array($path))
            $this->xpath = array_merge($this->xpath, $path);
        elseif (is_string($path))
            $this->xpath[] = $path;
        return $this;
    }

    public function prepend($path) {
        if (is_array($path))
            $this->xpath = array_merge($path, $this->xpath);
        elseif (is_string($path))
            array_unshift($this->xpath, $path);
        return $this;
    }

    protected function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setRoot($root) {
        $this->root = $root;
        return $this;
    }

    public function xPath() {
        $paths = $this->xpath;
        array_unshift($paths, $this->root);
        return implode('/', $paths);
    }

    public function fullPath() {
        $paths = $this->xpath;
        array_unshift($paths, $this->root);
        $paths[] = $this->name;
        return implode('/', $paths);
    }

}
