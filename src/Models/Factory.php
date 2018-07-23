<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 2:41 AM
 */

namespace Angujo\PhpRosa\Models;


abstract class Factory
{
    /**
     * @param null|array|\ReflectionClass|string $details
     * @return static
     */
    public static function create($details = null, $x = null)
    {
        if (is_object($details)) {
            $details = get_object_vars($details);
        }
        $det = is_array($details) ? $details : [];
        return (new static())->fromArray($det);
    }

    /**
     * @param array $details
     * @return static
     */
    protected function fromArray(array $details)
    {
        foreach ($details as $key => $value) {
            if (!property_exists($this, $key)) continue;
            $this->{$key} = $value;
        }
        return $this;
    }
}