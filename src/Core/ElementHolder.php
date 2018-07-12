<?php
/**
 * Created for phprosa.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:51 PM
 */

namespace Angujo\PhpRosa\Core;


abstract class ElementHolder
{
    public    $id;
    protected $name;
    protected $namespace;
    protected $namespace_path;
    protected $content;

    public function __construct($name, $prefix = null, $uri = null)
    {
        $this->name = $name;
        $this->namespace = $prefix;
        $this->namespace_path = $uri;
        $this->id = uniqid('id', false);
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return ElementHolder
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}