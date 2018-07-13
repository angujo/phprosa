<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 3:22 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


class Group extends ControlCollection
{
    const ELEMENT = 'group';

    public function addRepeat(Repeat $repeat)
    {
        return $this->addGroup($repeat);
    }
}