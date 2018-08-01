<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-08-01
 * Time: 4:40 AM
 */

namespace Angujo\PhpRosa\Core;


use Angujo\PhpRosa\Form\Bind;

class HeadBind
{
    private static $me;

    /** @var Bind[] */
    private $binds = [];

    /**
     * @param $id string
     * @return Bind
     */
    public static function getBind($id)
    {
        return static::init($id)->binds[$id];
    }

    /**
     * @param $id string
     * @return HeadBind
     */
    protected static function init($id)
    {
        $me = self::$me = self::$me ?: new self();
        if (!isset($me->binds[$id])) $me->binds[$id] = (new Bind())->setId($id);
        return $me;
    }

    /**
     * @return Bind[]
     */
    public static function getBinds()
    {
        return (self::$me ?: new self())->binds;
    }
}