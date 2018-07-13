<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 3:23 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


class Repeat extends ControlCollection
{
    const ELEMENT = 'repeat';
    private $count;

    /**
     * @param int $count
     * @return Repeat
     */
    public function setCount($count)
    {
        $this->count = is_numeric($count) ? (int)$count : null;
        return $this;
    }

}