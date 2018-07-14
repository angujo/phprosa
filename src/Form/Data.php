<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 9:42 AM
 */

namespace Angujo\PhpRosa\Form;

class Data
{
    const TYPE_STRING   = 'string';
    const TYPE_INT      = 'int';
    const TYPE_BOOL     = 'boolean';
    const TYPE_DECIMAL  = 'decimal';
    const TYPE_DATE     = 'date';
    const TYPE_TIME     = 'time';
    const TYPE_DATETIME = 'datetime';
    const TYPE_GEOPOINT = 'geopoint';
    const TYPE_GEOTRACE = 'geotrace';
    const TYPE_GEOSHAPE = 'geoshape';
    const TYPE_BINARY   = 'binary';
    const TYPE_BARCODE  = 'barcode';
    const TYPE_INTENT   = 'intent';
    const TYPE_EMAIL    = 'email';
    const TYPE_URL      = 'url';

    /**
     * @return array
     */
    public static function types()
    {
        return (new \ReflectionClass(__CLASS__))->getConstants();
    }
}