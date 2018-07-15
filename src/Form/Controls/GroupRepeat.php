<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 3:11 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Form\ControlField;

interface GroupRepeat
{
    function addControl(Control $field);

    function addGroup(ControlCollection $repeat);

    function setParent(self $parent);

    function getParent();
}