<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-15
 * Time: 4:40 PM
 */

namespace Angujo\PhpRosa\Form;


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
 */
trait TraitBind
{
    /** @var Bind */
    protected $binding;

    /*
       * Below we'll extend the Bind for the control
       */

    /**
     * @param $property
     * @param $value
     */
    public function __set($property, $value)
    {
        if (!$this->binding) {
            $this->binding = new Bind();
            $this->binding->nodeset = $this->name;
        }
        $this->binding->{$property} = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return $this->binding && isset($this->binding->{$name});
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (!$this->binding) return null;
        return $this->binding->{$name};
    }
}