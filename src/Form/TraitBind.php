<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-15
 * Time: 4:40 PM
 */

namespace Angujo\PhpRosa\Form;
use Angujo\PhpRosa\Core\HeadBind;


/**
 * Trait TraitBind
 * @package Angujo\PhpRosa\Form
 *
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
 * @property $binding;
 */
trait TraitBind
{
    /*
       * Below we'll extend the Bind for the control
       */

    /**
     * @param $property
     * @param $value
     */
    public function __set($property, $value)
    {
        if (!property_exists($this, 'id')) throw new \RuntimeException('Methods using "TraitBind" must have property "id"');
        HeadBind::getBind($this->id)->{$property} = $value;
        /*if (!$this->binding) {
            $this->binding = new Bind();
            $this->binding->nodeset = $this->name;
        }
        $this->binding->{$property} = $value;*/
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return true;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return HeadBind::getBind($this->id)->{$name};
    }
}