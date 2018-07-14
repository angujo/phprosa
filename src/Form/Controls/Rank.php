<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-12
 * Time: 7:01 PM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

class Rank extends Select
{
    protected $namespace = Args::NS_ODKFORM;
    protected $uri       = Args::URI_ODKFORMS;
    const ELEMENT =Elmt::RANK;
}