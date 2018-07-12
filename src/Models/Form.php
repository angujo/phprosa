<?php

namespace Angujo\PhpRosa\Models;

/**
 *
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
