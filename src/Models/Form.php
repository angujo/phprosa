<?php

namespace PhpRosa\Models;

/**
 * 
 */
class Form {

    use TraitGenerator;
    
    protected $root='xform';
    public $formID;
    public $name;
    public $version;
    public $hash;
    public $description;
    public $downloadURL;
    public $manifestUrl;

    public function __construct() {
    }

}
