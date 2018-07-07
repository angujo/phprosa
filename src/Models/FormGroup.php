<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 3:34 AM
 */

namespace PhpRosa\Models;


class FormGroup extends Factory implements FormInterface
{
    use TraitGenerator;

    protected $root = 'xforms-group';
    protected $groupId;
    protected $name;
    protected $listUrl;
    protected $descriptionText;
    protected $descriptionUrl;

    protected function __construct() { }
}