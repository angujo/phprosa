<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-22
 * Time: 9:44 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

/**
 * Class Itext
 * @package Angujo\PhpRosa\Form
 *
 */
class Itext
{
    const ELEMENT = Elmt::ITEXT;

    /** @var Translation[] */
    private $translations = [];
    /** @var self */
    private static $me;

    public function addTranslation($id, $label, $lang = Args::DEF_LANG)
    {
        $key = md5($lang);
        if (!isset($this->translations[$key])) $this->translations[$key] = new Translation($lang);
        $this->translations[$key]->addItem($id, $label);
        return $this;
    }

    public function write(Writer $writer)
    {
        $writer->startElement(Elmt::ITEXT);
        foreach ($this->translations as $translation) {
            $translation->write($writer);
        }
        $writer->endElement();
        return $writer;
    }

    /**
     * @param $id
     * @param $label
     * @param string $lang
     * @return Itext
     */
    public static function translate($id, $label, $lang = Args::DEF_LANG)
    {
        self::$me = self::$me ?: new self();
        return self::$me->addTranslation($id, $label, $lang);
    }

    /**
     * @param Writer $writer
     * @return Writer
     */
    public static function writeOut(Writer $writer)
    {
        self::$me = self::$me ?: new self();
        return self::$me->write($writer);
    }
}