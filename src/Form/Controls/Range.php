<?php
/**
 * Created for Angujo\PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:17 PM
 */

namespace Angujo\PhpRosa\Form\Controls;

use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Form\Data;
use Angujo\PhpRosa\Util\Elmt;

class Range extends Control
{
    const ELEMENT = Elmt::RANGE;
    private $start;
    private $end;
    private $step;

    protected function __construct($l, $n)
    {
        parent::__construct($l, $n);
        $this->type = Data::TYPE_INT;
    }

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

    public function write(Writer $writer, $closure = null)
    {
        $this->attributes['start'] = $this->start;
        $this->attributes['end'] = $this->end;
        $this->attributes['step'] = $this->step;
        parent::write($writer, $closure);
    }
}