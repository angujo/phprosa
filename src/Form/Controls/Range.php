<?php
/**
 * Created for Angujo\PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:17 PM
 */

namespace Angujo\PhpRosa\Form\Controls;

use Angujo\PhpRosa\Form\Control;

class Range extends Control
{
    const ELEMENT = 'range';
    private $start;
    private $end;
    private $step;

    public static function create($label, $name, $start = 0, $end = 5, $step = 1)
    {
        $me = new self($label, $name);
        $me->start = $start;
        $me->end = $end;
        $me->step = $step;
        return $me;
    }

    public function setStep($st)
    {
        $this->step = $st;
        return $this;
    }

    public function setStart($strt)
    {
        $this->start = $strt;
        return $this;
    }

    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }
}