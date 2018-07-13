<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 5:00 AM
 */

namespace Angujo\PhpRosa\Builder;

/**
 * Class XForm
 * @package Angujo\PhpRosa\Builder
 *
 * @see Head
 * @see Body
 */
class XForm
{
    private $head;
    private $body;

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
        throw new \RuntimeException("Method '$method' is not defined!");
    }
}