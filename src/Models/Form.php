<?php

namespace PhpRosa\Models;

/**
 * 
 */
class Form {

    use TraitGenerator;
    
    protected $root='xform';
    private $formID;
    private $name;
    private $version;
    private $hash;
    private $description;
    private $downloadURL;
    private $manifestUrl;

    private function __construct() {
    }
    
    public static function create($details) {
        if(is_object($details)){
            $details= get_object_vars($details);
        }
        $det= is_array($details)?$details:[];
        return (new self)->fromArray($det);
    }
    
    private function fromArray(array $details) {
        foreach ($details as $key => $value) {
            if(!property_exists($this, $key))                continue;
            $this->{$key}=$value;
        }
        return $this;
    }

}
