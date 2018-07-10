<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 9:14 AM
 */

namespace PhpRosa\Form;

use PhpRosa\Util\Strings;

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

    public function __set($property, $val)
    {
        $property = $this->slugged($property);
        if (!in_array($property, $this->attributes, false)) throw new \RuntimeException("'$property' is invalid!");
        $this->values[$property] = $val;
        $this->stringfy();
    }

    public function __get($property)
    {
        $property = $this->slugged($property);
        return array_key_exists($property, $this->stringed) ? $this->stringed[$property] : null;
    }

    public function xml(\XMLWriter $writer)
    {
        if (empty($this->stringed)) return $writer;
        $writer->startElement('bind');
        foreach ($this->stringed as $attr => $value) {
            $writer->writeAttribute($attr, $value);
        }
        $writer->endElement();
        return $writer;
    }

    public function __isset($property)
    {
        $property = $this->slugged($property);
        return array_key_exists($property, $this->values);
    }

    public function slugged($property)
    {
        foreach ($this->attributes as $attribute) {
            if (strcmp(Strings::slugify($attribute, [], '_'), $property) === 0) {
                $property = $attribute;
                break;
            }
        }
        return $property;
    }

    private function stringfy()
    {
        foreach ($this->values as $key => $value) {
            if (!in_array($key, $this->attributes, false)) continue;
            $this->stringed[$key] = $this->stringValue($key, $value);
        }
    }

    private function stringValue($key, $value)
    {
        switch ($key) {
            case 'type':
                return in_array($value, Data::types(), false) ? $value : Data::TYPE_STRING;
                break;
            case 'readonly':
            case 'required':
            case 'relevant':
            case 'saveIncomplete':
                return $value ? 'true()' : 'false()';
            case 'constraint':
            case 'nodeset':
            case 'calculate':
            case 'jr:requiredMsg':
            case 'jr:constraintMsg':
            case 'jr:preload':
            case 'jr:preloadParams':
                return $value;
            case 'orx:max-pixels':
                return is_numeric($value) ? $value : '1024';
        }
    }
}