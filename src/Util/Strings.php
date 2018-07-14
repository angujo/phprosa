<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-10
 * Time: 4:49 AM
 */

namespace Angujo\PhpRosa\Util;

class Strings
{
    public static function slugify($string, array $replace = array(), $delimiter = '-')
    {
        // https://github.com/phalcon/incubator/blob/master/Library/Phalcon/Utils/Slug.php
        if (!extension_loaded('iconv')) {
            throw new \Exception('iconv module not loaded');
        }
        // Save the old locale and set the new locale to UTF-8
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        if (!empty($replace)) {
            $clean = str_replace((array)$replace, ' ', $clean);
        }
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        // Revert back to the old locale
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }

   public static function camelCaseToSnake($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    public static function dottedToArray(&$arr, $path, $value)
    {
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            $arr = &$arr[$key];
        }

        $arr = $value;
    }
}