<?php

/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-10
 * Time: 6:23 AM
 */

namespace Angujo\PhpRosa\Form;

use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;
use Angujo\PhpRosa\Util\Strings;
use Angujo\PhpRosa\Core\Writer;

/**
 * Class Instance
 * @package Angujo\PhpRosa\Form
 *
 * @property string $id
 * @property string|int $version;
 * @property string $template;
 */
class Instance {

    private $primary = false;
    private $element = 'instance';
    private $root = 'root';

    /** @var MetaData */
    private $meta;
    private $default_path;
    private $recent_path;
    private $field_paths = [];

    /** @var ItemsList */
    private $listItem;
    private $bind;
    private $attributes = [
        'id' => 'id',
        'version' => Args::NS_ROSAFORM . ':version',
        'template' => Args::NS_JAVAROSA . ':template',
    ];
    private $values = [];

    private function __construct($r, $id) {
        $this->root = $r;
        $this->id = $id;
        $this->default_path = uniqid('xpath_', false);
    }

    public static function create($id, $root = 'root') {
        return new self($root, $id);
    }

    public function addField(Control $control) {
        $this->checkRoot();
        $control->setRootPath($this->root);
        $this->setRecentPath($control->getXpath());
        $control->translate();
        $this->field_paths[$this->recent_path][] = FieldSummary::create($control->getName(), $control->getDefaultValue());
        return $this;
    }

    private function checkRoot() {
        if ($this->primary) {
            $this->root = strcmp('root', $this->root) === 0 ? 'data' : $this->root;
        }
    }

    public function addFieldName($name_reference, $value = null) {
        $this->checkRoot();
        $name_reference = $this->fieldPath($name_reference);
        $this->field_paths[$this->recent_path][] = FieldSummary::create($name_reference, $value);
        return $this;
    }

    private function fieldPath($name) {
        $paths = array_filter(preg_split('/[^a-zA-Z\-_]/', $name));
        $name = array_pop($paths);
        $this->setRecentPath($paths);
        return $name;
    }

    private function setRecentPath(array $paths) {
        $xpath = implode('/', $paths) ?: null;
        $this->recent_path = (null === $xpath) ? $this->default_path : $xpath;
    }

    public function __set($property, $value) {
        $this->valid($property);
        $this->values[$property] = $value;
    }

    public function __isset($property) {
        $this->valid($property);
        return array_key_exists($property, $this->values);
    }

    public function __get($property) {
        $this->valid($property);
        return isset($this->values[$property]) ? $this->values[$property] : null;
    }

    public function setPrimary($s = true) {
        $this->primary = $s;
        return $this;
    }

    public function isPrimary() {
        return $this->primary;
    }

    /**
     * @param MetaData $meta
     * @return Instance
     */
    public function setMeta(MetaData $meta) {
        $this->meta = $meta;
        return $this;
    }

    public function write(Writer $writer) {
        if (!$this->primary && count($this->listItem))
            return $this->listing($writer);
        $writer->startElement($this->element);
        if (!$this->primary)
            $this->setAttributes($writer);
        $writer->startElement($this->root);
        if ($this->primary)
            $this->setAttributes($writer);
        $this->setXPath($writer);
        if ($this->primary && $this->meta)
            $this->meta->write($writer);
        $writer->endElement();
        $writer->endElement();
        return $writer;
    }

    public function setItemsList(ItemsList $itemsList) {
        $this->listItem = $itemsList;
        return $this;
    }

    public function addItem(Item $item) {
        if (null === $this->listItem || !is_object($this->listItem) || !is_a($this->listItem, ItemsList::class))
            $this->listItem = ItemsList::create('root');
        $this->listItem->addItem($item);
        return $this;
    }

    private function listing(Writer $writer) {
        $this->listItem->nullifyRoot();
        $writer->startElement($this->element);
        $writer->writeAttribute('id', $this->id);
        $writer->startElement($this->root);
        $this->listItem->write($writer);
        $writer->endElement();
        $writer->endElement();
        return $writer;
    }

    private function setAttributes(Writer $writer) {
        foreach ($this->values as $key => $value) {
            if (0 === strcasecmp('version', $key)) {
                $writer->writeAttributeNs(Args::NS_ROSAFORM, $key, Args::URI_ROSAFORM, $value);
            }elseif (0=== strcmp('template', $key)) {
                 $writer->writeAttributeNs(Args::NS_JAVAROSA, $key, Args::URI_JAVAROSA, $value);
            } else {
                $writer->writeAttribute($this->attributes[$key], $value);
            }
        }
    }

    private function setXPath(Writer $writer) {
        if (isset($this->field_paths[$this->default_path])) {
            foreach ($this->field_paths[$this->default_path] as $field) {
                $field->write($writer);
            }
            unset($this->field_paths[$this->default_path]);
        }
        $output = [];
        foreach ($this->field_paths as $field_path => $values) {
            $paths = implode('.', array_filter(array_map('trim', explode('.', str_replace('/', '.', $field_path)))));
            Strings::dottedToArray($output, $paths, $values);
        }
        $this->xPath($output, $writer);
    }

    private function xPath(array $entries, Writer $writer) {
        $i = 0;
        foreach ($entries as $m => $entry) {
            if (!$i && strcmp($m, $this->root) === 0) {
                $this->xPath($entry, $writer);
            } elseif (is_array($entry)) {
                $writer->startElement($m);
                $this->xPath($entry, $writer);
                $writer->endElement();
            } else {
                $entry->write($writer);
            }
            $i++;
        }
    }

    private function valid($property) {
        if (!array_key_exists($property, $this->attributes))
            throw new \RuntimeException("'$property' is invalid!");
    }

    public function itemSetReference() {
        if ($this->primary || !$this->listItem)
            return null;
        return "instance('$this->id')/$this->root/" . Elmt::ITEM;
    }

    public function primaryBind() {
        if (!$this->primary || !$this->meta || ($this->meta && !$this->meta->instanceID))
            return null;
        if ($this->bind)
            return $this->bind;
        $bind = new Bind();
        $bind->nodeset = '/' . $this->root . '/' . Elmt::META . '/instanceID';
        $bind->type = Data::TYPE_STRING;
        $bind->readonly = true;
        $bind->calculate = "concat('uuid:', uuid())";
        return $this->bind = $bind;
    }

    /**
     * @return string
     */
    public function getRoot() {
        return $this->root;
    }

}
