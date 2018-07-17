<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 3:34 AM
 */

namespace Angujo\PhpRosa\Models;

/**
 * Class FormGroup
 * @package Angujo\PhpRosa\Models
 *
 * @property $groupId;
 * @property $name;
 * @property $listUrl;
 * @property $descriptionText;
 * @property $descriptionUrl;
 */
class FormGroup extends Factory implements FormInterface
{
    use TraitGenerator;

    const ELEMENT = 'xforms-group';

    protected function __construct() { $this->attributes = ['name', 'groupId', 'listUrl', 'descriptionText', 'descriptionUrl']; }
}