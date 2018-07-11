<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-10
 * Time: 6:23 AM
 */

namespace PhpRosa\Form;

use PhpRosa\Models\Args;
use PhpRosa\Util\Strings;

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
    private $primary = false;
    private $element = 'instance';
    private $root    = 'root';
    /** @var MetaData */
    private $meta;
    private $default_path;
    private $recent_path;
    private $field_paths = [];
    /** @var ItemsList */
    private $listItem;

    private $attributes = [
        'id' => 'id',
        'version' => Args::ELMT_ROSAFORM . ':version',
        'template' => Args::ELMT_JAVAROSA . ':template',
    ];
    private $values     = [];

    private function __construct($r, $id)
    {
        $this->root = $r;
        $this->id = $id;
        $this->default_path = uniqid('xpath_', false);
    }

    public static function create($id, $root = 'root')
    {
        return new self($root, $id);
    }

    public function addFieldName($name, $xpath = null, $value = null)
    {
        $this->recent_path = (null === $xpath && null === $this->recent_path) ? $this->default_path : (null === $xpath ? $this->recent_path : $xpath);
        $this->field_paths[$this->recent_path][] = FieldSummary::create($name, $value);
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

    public function setPrimary($s = true)
    {
        $this->primary = $s;
        return $this;
    }

    public function isPrimary()
    {
        return $this->primary;
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

    public function xml(\XMLWriter $writer)
    {
        if (!$this->primary && count($this->listItem)) return $this->listing($writer);
        $root = $this->root;
        if ($this->primary) {
            $root = strcmp('root', $this->root) === 0 ? 'data' : $this->root;
        }
        $writer->startElement($this->element);
        if (!$this->primary) $this->setAttributes($writer);
        $writer->startElement($root);
        if ($this->primary) $this->setAttributes($writer);
        $this->setXPath($writer);
        if ($this->primary && $this->meta) $this->meta->xml($writer);
        $writer->endElement();
        $writer->endElement();
        return $writer;
    }

    public function setItemsList(ItemsList $itemsList)
    {
        $this->listItem = $itemsList;
        return $this;
    }

    public function addItem(Item $item)
    {
        if (null === $this->listItem || !is_object($this->listItem) || !is_a($this->listItem, ItemsList::class)) $this->listItem = ItemsList::create('root');
        $this->listItem->addItem($item);
        return $this;
    }

    private function listing(\XMLWriter $writer)
    {
        $writer->startElement($this->element);
        $writer->writeAttribute('id',$this->id);
        $this->listItem->xml($writer);
        $writer->endElement();
        return $writer;
    }

    private function setAttributes(\XMLWriter $writer)
    {
        foreach ($this->values as $key => $value) {
            $writer->writeAttribute($this->attributes[$key], $value);
        }
    }

    private function setXPath(\XMLWriter $writer)
    {
        if (isset($this->field_paths[$this->default_path])) {
            foreach ($this->field_paths[$this->default_path] as $field) {
                $field->xml($writer);
            }
            unset($this->field_paths[$this->default_path]);
        }
        $output = [];
        foreach ($this->field_paths as $field_path => $values) {
            $paths = implode('.', array_filter(array_map('trim', explode('.', $field_path))));
            Strings::dottedToArray($output, $paths, $values);
        }
        $this->xPath($output, $writer);
    }

    private function xPath(array $entries, \XMLWriter $writer)
    {
        foreach ($entries as $m => $entry) {
            if (is_array($entry)) {
                $writer->startElement($m);
                $this->xPath($entry, $writer);
                $writer->endElement();
            } else {
                $entry->xml($writer);
            }
        }
    }

    private function valid($property)
    {
        if (!array_key_exists($property, $this->attributes)) throw new \RuntimeException("'$property' is invalid!");
    }
}