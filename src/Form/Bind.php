<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 9:14 AM
 */

/**
 * Class Bind
 * @property $nodeset
 * @property $type
 * @property $readonly
 * @property $required
 * @property $relevant
 * @property $constraint
 * @property $calculate
 * @property $save_incomplete
 * @property $jr_required_msg
 * @property $jr_constraint_msg
 * @property $jr_preload
 * @property $jr_preload_params
 * @property $orx_max_pixels
 */
class Bind
{
    protected $attributes = [
        'nodeset',
        'type',
        'readonly',
        'required',
        'relevant',
        'constraint',
        'calculate',
        'saveIncomplete',
        'jr:requiredMsg',
        'jr:constraintMsg',
        'jr:preload',
        'jr:preloadParams',
        'orx:max-pixels',
    ];

    private $values = [];

    private $stringed = [];

    private function stringfy()
    {
        foreach ($this->values as $key => $value) {
            $this->stringed[$key] = $this->stringValue($key, $value);
        }
    }

    private function stringValue($key, $value)
    {
        switch ($key) {
            case 'nodeset':
                break;
            case 'type':
                return in_array($value, Data::types(), false) ? $value : Data::TYPE_STRING;
                break;
            case 'readonly':
                break;
            case 'required':
                break;
            case 'relevant':
                break;
            case 'constraint':
                break;
            case 'calculate':
                break;
            case 'saveIncomplete':
                break;
            case 'jr:requiredMsg':
                break;
            case 'jr:constraintMsg':
                break;
            case 'jr:preload':
                break;
            case 'jr:preloadParams':
                break;
            case 'orx:max-pixels':
                break;
        }
    }
}