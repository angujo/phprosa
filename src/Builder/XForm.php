<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 5:00 AM
 */

namespace Angujo\PhpRosa\Builder;

use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Bind;
use Angujo\PhpRosa\Form\ControlField;
use Angujo\PhpRosa\Form\Controls\Group;
use Angujo\PhpRosa\Form\Controls\Repeat;
use Angujo\PhpRosa\Form\Instance;
use Angujo\PhpRosa\Form\Item;

/**
 * Class XForm
 * @package Angujo\PhpRosa\Builder
 *
 * @see Head
 * @see Body
 *
 * @method setTitle(string $title)
 * @method setInstances(Instance [] $instances)
 * @method addInstances(Instance $instance)
 * @method setBindings(Bind [] $binds)
 * @method addBinding(Bind $bind)
 * @method startInstance(string $id, string $root = 'root')
 * @method addItem(Item $item)
 * @method endInstance()
 * @method addControl(ControlField $control)
 * @method addGroup(Group $group)
 * @method addRepeat(Repeat $repeat)
 * @method startRepeat(string $ref = null, string $label = null, int $count = 0)
 * @method startGroup(string $ref = null, string $label = null)
 * @method endRepeat()
 * @method endGroup()
 */
class XForm
{
    /** @var Head */
    private $head;
    /** @var Body */
    private $body;
    /** @var Html */
    private $html;
    private $processed = false;

    public function __construct(Html $html = null, Writer $writer = null)
    {
        $this->html = $html ? new Html($writer) : $html;
    }

    /**
     * @param Head $head
     * @return XForm
     */
    public function setHead(Head $head)
    {
        $this->head = $head;
        return $this;
    }

    /**
     * @param Body $body
     * @return XForm
     */
    public function setBody(Body $body)
    {
        $this->body = $body;
        return $this;
    }

    public function __call($method, $args)
    {
        if (null === $this->body) $this->body = new Body();
        if (null === $this->head) $this->head = new Head($this->body);
        if (method_exists($this->head, $method)) return call_user_func_array([$this->head, $method], $args);
        if (method_exists($this->body, $method)) return call_user_func_array([$this->body, $method], $args);
        throw new \BadMethodCallException("Method '$method' is not defined!");
    }

    public function write(Writer $writer = null)
    {
        $this->html->setBody($this->body);
        $this->html->setHead($this->head);
        $this->processed = true;
        return $this->html->write($writer);
    }

    public function xml()
    {
        if (!$this->processed) $this->write();
        return $this->html->xml();
    }
}