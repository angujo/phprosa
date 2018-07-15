<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 9:14 AM
 */

namespace Angujo\PhpRosa\Form;

use Angujo\PhpRosa\Core\TraitArray;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;
use Angujo\PhpRosa\Util\Strings;
use Angujo\PhpRosa\Core\Writer;

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
 * @property $required_msg
 * @property $constraint_msg
 * @property $preload
 * @property $preload_params
 * @property $max_pixels
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
        Args::NS_JAVAROSA . ':requiredMsg',
        Args::NS_JAVAROSA . ':constraintMsg',
        Args::NS_JAVAROSA . ':preload',
        Args::NS_JAVAROSA . ':preloadParams',
        Args::NS_ROSAFORM . ':max-pixels',
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

    public function write(Writer $writer)
    {
        if (empty($this->stringed)) return $writer;
        $writer->startElement(Elmt::BIND);
        foreach ($this->stringed as $attr => $value) {
            if (false !== strpos($attr, ':')) {
                $sp = explode(':', $attr);
                $ns = 0 === strcmp(Args::NS_ROSAFORM, $sp[0]) ? Args::URI_ROSAFORM : Args::URI_JAVAROSA;
                $writer->writeAttributeNs($sp[0], $sp[1], $ns, $value);
                continue;
            }
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
            $attr = explode(':', $attribute);
            $attr = Strings::camelCaseToSnake(count($attr) > 1 ? $attr[1] : $attr[0]);
            if (strcmp($attr, $property) === 0) {
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
            case 'required':
                if (!$this->required_msg && $value) $this->required_msg='This field is required!';
            case 'readonly':
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

    public function arrayAccess()
    {
        return $this->values;
    }
}