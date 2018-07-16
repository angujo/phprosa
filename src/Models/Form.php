<?php

namespace Angujo\PhpRosa\Models;

/**
 * Class Form
 * @package Angujo\PhpRosa\Models
 *
 * @property $formID;
 * @property $name;
 * @property $version;
 * @property $hash;
 * @property $description;
 * @property $downloadURL;
 * @property $manifestUrl;
 */
class Form extends Factory implements FormInterface
{

    use TraitGenerator;

    protected $root = 'xform';
    protected $formID;
    protected $name;
    protected $version;
    protected $hash;
    protected $description;
    protected $downloadURL;
    protected $manifestUrl;

    protected function __construct() { }

}
