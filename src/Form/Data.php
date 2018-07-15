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
    const TYPE_AUDIO    = 'audio';
    const TYPE_VIDEO    = 'video';
    const TYPE_FILE     = 'file';
    const TYPE_PICTURE  = 'picture';
    const TYPE_IMAGE    = self::TYPE_PICTURE;

    private static $types = [Data::TYPE_EMAIL => 'string', Data::TYPE_URL => 'string',];

    /**
     * @return array
     */
    public static function types()
    {
        return array_filter((new \ReflectionClass(__CLASS__))->getConstants(), function ($t) { return !array_key_exists($t, self::$types); });
    }
}