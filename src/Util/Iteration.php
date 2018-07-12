<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-10
 * Time: 7:56 PM
 */

namespace Angujo\PhpRosa\Util;


abstract class Iteration implements \Iterator, \ArrayAccess, \Countable
{
    protected $list = [];

    public function rewind()
    {
        reset($this->list);
    }

    public function current()
    {
        return current($this->list);
    }

    public function key()
    {
        return key($this->list);
    }

    public function next()
    {
        return next($this->list);
    }

    public function valid()
    {
        $key = key($this->list);
        return $key !== null && false !== $key;
    }

    public function offsetExists($offset)
    {
        return isset($this->list[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->list[$offset]) ? $this->list[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (null === $offset) $this->list[] = $value;
        else $this->list[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->list[$offset]);
    }

    public function count()
    {
        $c = count($this->list);
        return ++$c;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->list);
    }
}