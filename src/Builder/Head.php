<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 4:59 AM
 */

namespace Angujo\PhpRosa\Builder;


use Angujo\PhpRosa\Form\Bind;
use Angujo\PhpRosa\Form\Instance;

class Head
{
    private $title;
    /** @var Instance[] */
    private $instances = [];
    /** @var Bind[] */
    private $bindings = [];
    /** @var Instance|null */
    private $primaryInstance;

    public function __construct() { }

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
        $this->bindings[] = $bind;
        return $this;
    }
}