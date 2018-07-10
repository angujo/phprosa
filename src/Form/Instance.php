<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-10
 * Time: 6:23 AM
 */

namespace PhpRosa\Form;

use PhpRosa\Models\Args;

/**
 * Class Instance
 * @package PhpRosa\Form
 *
 * @property string $id
 * @property string|int $version;
 * @property string $template;
 */
class Instance
{
    private $primary     = false;
    private $root        = 'root';
    private $meta;
    private $default_path;
    private $recent_path;
    private $field_paths = [];

    private $attributes = [
        'id' => 'id',
        'version' => Args::ELMT_ROSAFORM . ':version',
        'template' => Args::ELMT_JAVAROSA . ':template',
    ];
    private $values     = [];

    private function __construct($r)
    {
        $this->root = $r;
        $this->default_path = uniqid('xpath_', false);
    }

    public static function create($root = 'root')
    {
        return new self($root);
    }

    public function addFieldName($name, $xpath = null, $value = null)
    {
        $this->recent_path = (null === $xpath && null === $this->recent_path) ? $this->default_path : (null === $xpath ? $this->recent_path : $xpath);
        $item = null === $value ? $name : [$name, $value];
        $this->field_paths[$this->recent_path][] = $item;
        return $this;
    }

    public function __set($property, $value)
    {
        $this->valid($property);
        $this->values[$property] = $value;
    }

    public function __isset($property)
    {
        $this->valid($property);
        return array_key_exists($property, $this->values);
    }

    public function __get($property)
    {
        $this->valid($property);
        return isset($this->values[$property]) ? $this->values[$property] : null;
    }

    public function isPrimary($s = true)
    {
        $this->primary = $s;
    }

    /**
     * @param MetaData $meta
     * @return Instance
     */
    public function setMeta(MetaData $meta)
    {
        $this->meta = $meta;
        return $this;
    }

    private function valid($property)
    {
        if (!array_key_exists($property, $this->attributes)) throw new \RuntimeException("'$property' is invalid!");
    }
}