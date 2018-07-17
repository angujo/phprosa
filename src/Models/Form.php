<?php

namespace Angujo\PhpRosa\Models;
use Angujo\PhpRosa\Util\Elmt;

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

    const ELEMENT = Elmt::FORM;

    protected function __construct()
    {
        $this->attributes = [
            'formID',
            'name',
            'version',
            'hash',
            'description',
            'downloadURL',
            'manifestUrl',
        ];
    }

}
