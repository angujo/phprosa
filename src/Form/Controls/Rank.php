<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-12
 * Time: 7:01 PM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Models\Args;

class Rank extends Select
{
    protected $namespace = Args::ELMT_ODKFORM;
    protected $uri       = Args::ODK_XFORMS;
    const ELEMENT = 'rank';
}