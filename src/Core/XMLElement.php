<?php
/**
 * Created for phprosa.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:51 PM
 */

namespace Angujo\PhpRosa\Core;


use Angujo\PhpRosa\Models\Args;

abstract class XMLElement
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
     * @return XMLElement
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function preXml(&$attributes){
        if (array_key_exists($this->id, Session::$xml_namespaces)) {
            foreach (Session::$xml_namespaces[$this->id] as $prefix => $uri) {
                $attributes[] = (new Attribute(Args::XMLNS.':'.$prefix, null, null))->setContent($uri);
            }
        }
        $this->namespace_path = null;
    }
}