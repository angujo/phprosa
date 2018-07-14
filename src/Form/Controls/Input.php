<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 5:12 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Form\Control;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Data;

/**
 * Class Input
 * @package Angujo\PhpRosa\Form\Controls
 *
 * @method static Input decimal(string $label, string $name, int $places = 0);
 * @method static Input datetime(string $label, string $name);
 * @method static Input geopoint(string $label, string $name);
 * @method static Input geotrace(string $label, string $name);
 * @method static Input geoshape(string $label, string $name);
 * @method static Input boolean(string $label, string $name);
 * @method static Input barcode(string $label, string $name);
 * @method static Input intent(string $label, string $name);
 * @method static Input binary(string $label, string $name);
 * @method static Input string(string $label, string $name);
 * @method static Input email(string $label, string $name);
 * @method static Input date(string $label, string $name);
 * @method static Input time(string $label, string $name);
 * @method static Input int(string $label, string $name);
 * @method static Input url(string $label, string $name);
 */
class Input extends Control
{
    const ELEMENT = 'input';
    private static $types = [Data::TYPE_EMAIL => 'string', Data::TYPE_URL => 'string',];

    public static function integer($label, $name)
    {
        $me = self::int($label, $name);
        $me->type = Data::TYPE_INT;
        return $me;
    }

    public static function __callStatic($name, $arguments)
    {
        if (count($arguments) < 2) throw new \RuntimeException('At least LABEL and NAME REFERENCE are required for input!');
        $types = array_merge(Data::types(), array_keys(self::$types));
        if (!in_array($name, $types, false)) throw new \BadMethodCallException("'$name' is an invalid input type!");
        /** @var self $me */
        $me = call_user_func([__CLASS__, 'create'], $arguments[0], $arguments[1]);
        $_name = array_key_exists($name, array_keys(self::$types)) ? self::$types[$name] : $name;
        $me->type = strtolower($_name);
        unset($arguments[0], $arguments[1]);
        if (!empty($arguments)) self::bind($name, $me, $arguments);
        return $me;
    }

    private static function bind($name, self $me, array $arguments)
    {
        switch ($name) {
            case Data::TYPE_DECIMAL:
                $pl = (int)$arguments[0];
                $me->constraint = "regex(.,'^([1-9])([0-9]+)?(\.([0-9]{0,$pl}))?$')";
                break;
            case Data::TYPE_EMAIL:
                $me->constraint = "regex(.,'^([a-zA-Z])([\w\-]+)?\@([\w\-]+)\.([a-zA-Z]+)$')";
                break;
            case Data::TYPE_URL:
                $me->constraint = "regex(.,'^(http(s)?\:\/\/)?([a-zA-Z])([\w\-\.]+)?([\w\-]+)\.([a-zA-Z]+)$')";
                break;
        }
        if ($me->constraint) $me->constraint_msg = 'Enter valid value!';
    }
}