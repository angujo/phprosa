<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-15
 * Time: 1:24 PM
 */

namespace Angujo\PhpRosa\Core;


use Angujo\PhpRosa\Form\Controls\ControlCollection;

trait TraitArray
{
    protected $for_array = [];

    public function arrayAccess()
    {
        if (!is_array($this->for_array)) {
            $property = $this->{$this->for_array};
            return is_array($property) ? $this->_checkKey($property) : $property;
        }
        $this->for_array = !empty($this->for_array) ? $this->for_array : array_keys(get_object_vars($this));
        if (false !== ($key = array_search('for_array', $this->for_array))) unset($this->for_array[$key]);
        return $this->_arrayKeys();
    }

    private function _arrayKeys()
    {
        return $this->_objectKeys($this, $this->for_array);
    }

    /**
     * @param $object
     * @param array $keys
     * @return array
     */
    private function _objectKeys($object, array $keys)
    {
        $out = [];
        foreach ($keys as $key) {
            if (null === $object->{$key}) continue;
            $out[$key] = $this->_checkKey($object->{$key});
        }
        return $out;
    }

    private function _checkKey($property)
    {
        if (is_array($property)) {
            return array_map(function ($item) { return $this->_checkKey($item); }, $property);
        }
        if (is_object($property)) {
            if (method_exists($property, 'arrayProperties')) {
                $keys = $property->arrayProperties();
                return is_array($keys) ? $this->_objectKeys($property, $keys) : $property->{$keys};
            }
            return method_exists($property, 'arrayAccess') ? $property->arrayAccess() : (array)$property;
        }
        return $property;
    }
}