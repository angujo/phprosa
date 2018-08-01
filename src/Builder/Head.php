<?php

/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 4:59 AM
 */

namespace Angujo\PhpRosa\Builder;

use Angujo\PhpRosa\Core\HeadBind;
use Angujo\PhpRosa\Core\IdPath;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Bind;
use Angujo\PhpRosa\Form\Instance;
use Angujo\PhpRosa\Form\Item;
use Angujo\PhpRosa\Form\Itext;
use Angujo\PhpRosa\Form\MetaData;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

class Head
{

    private $title;

    /** @var Instance[] */
    private $instances = [];

    /** @var Bind[] */
    private $bindings = [];

    /** @var Instance|null */
    private $primaryInstance;

    /** @var Body */
    private $body;

    /** @var Instance */
    private $instance;

    /** @var MetaData */
    private $meta;

    /**
     * Head constructor.
     * @param $body Body
     */
    public function __construct($body = null)
    {
        $this->body = is_object($body) && is_a($body, Body::class) ? $body : null;
        IdPath::setRoot('data');
    }

    /**
     * @param mixed $title
     * @return Head
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setMeta(MetaData $metaData)
    {
        $this->meta = &$metaData;
        return $this;
    }

    public function setFormDetails($id, $version)
    {
        if (!$this->primaryInstance) {
            $this->primaryInstance = Instance::create($id);
            $this->primaryInstance->setPrimary();
        }
        $this->primaryInstance->id = $id;
        $this->primaryInstance->version = $version;
    }

    /**
     * @param Instance[] $instances
     * @return Head
     */
    public function setInstances($instances)
    {
        $this->primaryInstance = null;
        $this->instances = [];
        foreach ($instances as $instance) {
            if ($instance->isPrimary()) {
                if ($this->primaryInstance)
                    continue;
                $this->primaryInstance = &$instance;
                continue;
            }
            $this->instances[] = $instance;
        }
        return $this;
    }

    public function addInstance(Instance $instance)
    {
        if ($this->primaryInstance && $instance->isPrimary())
            return $this;
        if (!$this->primaryInstance && $instance->isPrimary()) {
            $this->primaryInstance = &$instance;
            return $this;
        }
        $this->instances[] = &$instance;
        return $this;
    }

    /**
     * @param Bind[] $bindings
     * @return Head
     */
    public function setBindings($bindings)
    {
        $this->bindings = $bindings;
        return $this;
    }

    public function addBinding(Bind $bind)
    {
        $this->bindings[] = &$bind;
        return $this;
    }

    /**
     * Method to write the defined elements
     *
     * @param Writer $writer
     * @param null|Body $body
     */
    public function write(Writer $writer, $body = null)
    {
        $this->wrap($writer, $body);
    }

    /**
     * Method to allow addition of extra elements before and after defined elements.
     *
     * @param Writer $writer
     * @param null|Body $body
     * @param \Closure|null $after Called before any element in MODEL
     * @param \Closure|null $before Called after all elements in MODEL
     */
    public function wrap(Writer $writer, $body = null, \Closure $after = null, \Closure $before = null)
    {
        if (is_object($body) && is_a($body, Body::class))
            $this->body = $body;
        if ($this->primaryInstance && $this->meta) {
            $this->primaryInstance->setMeta($this->meta);
        }
        $writer->startElementNs(Args::NS_XHTML, Elmt::HEAD, Args::URI_XHTML);
        $writer->writeElementNs(Args::NS_XHTML, Elmt::TITLE, Args::URI_XHTML, $this->title ?: Args::PROJECT);
        $writer->startElement(Elmt::MODEL);
        if (is_callable($before))
            $before($writer);
        if ($this->primaryInstance)
            $this->primaryInstance->write($writer);
        Itext::writeOut($writer);
        if ($this->primaryInstance && $this->primaryInstance->primaryBind()) {
            $this->primaryInstance->primaryBind()->write($writer);
        }
        foreach (HeadBind::getBinds() as $binding) {
            $binding->write($writer);
        }
        if ($this->instances) {
            foreach ($this->instances as $instance) {
                $instance->write($writer);
            }
        }
        if (is_callable($after))
            $after($writer);
        $writer->endElement();
        $writer->endElement();
    }

    public function startInstance($id, $root = 'root')
    {
        if ($this->instance)
            $this->addInstance($this->instance);
        $this->instance = Instance::create($id, $root);
    }

    public function addItem(Item $item)
    {
        if (!$this->instance)
            return;
        $this->instance->addItem($item);
    }

    public function endInstance()
    {
        if (!$this->instance)
            return;
        $this->addInstance($this->instance);
        $this->instance = null;
    }

}
