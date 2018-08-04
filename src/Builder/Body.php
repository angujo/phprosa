<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 4:58 AM
 */

namespace Angujo\PhpRosa\Builder;


use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Bind;
use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Form\ControlField;
use Angujo\PhpRosa\Form\Controls\ControlCollection;
use Angujo\PhpRosa\Form\Controls\Group;
use Angujo\PhpRosa\Form\Controls\GroupRepeat;
use Angujo\PhpRosa\Form\Controls\Repeat;
use Angujo\PhpRosa\Form\Controls\Select;
use Angujo\PhpRosa\Form\Instance;
use Angujo\PhpRosa\Form\ItemSet;
use Angujo\PhpRosa\Form\ItemsList;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;
use Angujo\PhpRosa\Util\Strings;

/**
 * Class Body
 * @package Angujo\PhpRosa\Builder
 */
class Body
{
    /** @var Control[]|GroupRepeat[]|Control[] */
    private $controls = [];
    /** @var Group|Repeat */
    private $open_group;

    /** @var Bind[] */
    private $bindings = [];
    /** @var ItemsList[] */
    private $lists = [];

    public function __construct() { }

    public function addControl(Control $control)
    {
        if ($this->open_group) {
            $this->open_group->addControl($control);
            return $this;
        }
        $this->controls[] = $control;
        return $this;
    }

    public function addGroup(Group $group)
    {
        if ($this->open_group) {
            $this->open_group->addGroup($group);
            return $this;
        }
        $this->controls[] = $group;
        return $this;
    }

    public function addRepeat(Repeat $repeat)
    {
        if ($this->open_group) {
            if (!is_a($this->open_group, Repeat::class)) $this->open_group->addRepeat($repeat);
            return $this;
        }
        $this->controls[] = $repeat;
        return $this;
    }

    public function startRepeat($ref = null, $label = null, $count = 0)
    {
        $repeat = Repeat::create($ref, $label);
        $repeat->setCount($count);
        return $this->collectionInitialize($repeat);
    }

    public function endRepeat()
    {
        $this->endGroup();
    }

    public function startGroup($ref = null, $label = null)
    {
        $group = Group::create($ref, $label);
        return $this->collectionInitialize($group);
    }

    /**
     * @param $collection Group|Repeat
     * @return $this
     */
    private function collectionInitialize($collection)
    {
        if ($this->open_group) {
            $collection->setParent($this->open_group);
            $this->open_group->addGroup($collection);
        }
        $this->open_group = $collection;
        return $this;
    }

    public function endGroup()
    {
        if (!$this->open_group) return;
        if ($this->open_group->getParent()) {
            $this->open_group = $this->open_group->getParent();
            return;
        }
        $this->controls[] = $this->open_group;
        $this->open_group = null;
    }

    /**
     * Method to write defined elements
     *
     * @param Writer $writer
     */
    public function write(Writer $writer)
    {
        $this->wrap($writer);
    }

    /**
     * Method to allow addition of extra elements before and after defined elements
     *
     * @param Writer $writer
     * @param \Closure|null $after
     * @param \Closure|null $before
     */
    public function wrap(Writer $writer, \Closure $after = null, \Closure $before = null)
    {
        $writer->startElementNs(Args::NS_XHTML, Elmt::BODY, Args::URI_XHTML);
        if (is_callable($before)) $before($writer);
        foreach ($this->controls as $control) {
            $control->write($writer);
        }
        if (is_callable($after)) $after($writer);
        $writer->endElement();
    }

    public function json_array()
    {
        $out = [];
        foreach ($this->controls as $control) {
            $out[] = $control->arrayAccess();
        }
        return $out;
    }
}