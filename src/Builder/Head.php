<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 4:59 AM
 */

namespace Angujo\PhpRosa\Builder;


use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Bind;
use Angujo\PhpRosa\Form\Instance;
use Angujo\PhpRosa\Models\Args;

class Head
{
    private $title;
    /** @var Instance[] */
    private $instances = [];
    /** @var Bind[] */
    private $bindings = [];
    /** @var Instance|null */
    private $primaryInstance;

    const ELEMENT = 'head';
    const MODEL   = 'model';
    const TITLE   = 'title';
    /** @var Body */
    private $body;

    /**
     * Head constructor.
     * @param $body Body
     */
    public function __construct($body = null) { $this->body = is_object($body) && is_a($body, Body::class) ? $body : null; }

    /**
     * @param mixed $title
     * @return Head
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
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
                if ($this->primaryInstance) continue;
                $this->primaryInstance =& $instance;
                continue;
            }
            $this->instances[] = $instance;
        }
        return $this;
    }

    public function addInstance(Instance $instance)
    {
        if ($this->primaryInstance && $instance->isPrimary()) return $this;
        if (!$this->primaryInstance && $instance->isPrimary()) {
            $this->primaryInstance =& $instance;
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

    private function parseBody()
    {
        //TODO loop through body controls and consolidating the instances
    }

    /**
     * @param Writer $writer
     * @param null|Body $body
     */
    public function write(Writer $writer, $body = null)
    {
        if (is_object($body) && is_a($body, Body::class)) $this->body = $body;
        $this->parseBody();
        $writer->startElementNs(Args::NS_XHTML, self::ELEMENT, Args::URI_XHTML);
        $writer->writeElementNs(Args::NS_XHTML, self::TITLE, Args::URI_XHTML, $this->title ?: Args::PROJECT);
        $writer->startElement(self::MODEL);
        if ($this->primaryInstance) $this->primaryInstance->write($writer);
        if ($this->bindings) {
            foreach ($this->bindings as $binding) {
                $binding->write($writer);
            }
        }
        if ($this->instances) {
            foreach ($this->instances as $instance) {
                $instance->write($writer);
            }
        }
        $writer->endElement();
        $writer->endElement();
    }
}