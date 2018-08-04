<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-08-04
 * Time: 6:43 AM
 */

namespace Angujo\PhpRosa\Core;


use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

class Language
{
    /** @var Translation[] */
    private static $langs = [];

    private function __construct() { }

    /**
     * @param $content string|int|float
     * @return bool
     */
    public static function translatable($content)
    {
        return null !== $content && !is_numeric($content);
    }

    public static function translate(Translation $trans, $lang = Args::DEF_LANG)
    {
        self::$langs[$lang][$trans->getId()] = $trans;
    }

    public static function pathTranslation($id, $content, $lang = Args::DEF_LANG)
    {
        self::suffixedPath($id, $content, null, $lang);
    }

    public static function suffixedPath($id, $content, $suffix, $lang = Args::DEF_LANG)
    {
        self::translate(Translation::create($id, $content, $suffix), $lang);
    }

    /**
     * @return Translation[]
     */
    public static function all()
    {
        return self::$langs;
    }

    public static function get($lang)
    {
        return isset(self::$langs[$lang]) ? self::$langs[$lang] : [];
    }

    public static function languages()
    {
        return array_keys(self::$langs);
    }

    public static function write(Writer $writer)
    {
        /**
         * @var string $lang
         * @var Translation[]|array $trans
         */
        foreach (self::$langs as $lang => $trans) {
            $writer->startElement(Elmt::TRANSLATION);
            if (0 === strcmp(Args::DEF_LANG, $lang)) $writer->writeAttribute('default', 'true()');
            $writer->writeAttribute('lang', $lang);
            foreach ($trans as $item) {
                $item->write($writer);
            }
            $writer->endElement();
        }
        return $writer;
    }
}