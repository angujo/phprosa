<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-22
 * Time: 9:44 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\Language;
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

    /** @var self */
    private static $me;

    public function write(Writer $writer)
    {
        $writer->startElement(Elmt::ITEXT);
        Language::write($writer);
        $writer->endElement();
        return $writer;
    }

    /**
     * JR's iText referencing function
     * @method jr
     * @param  string $ref Reference Path
     * @return string      Functioned URL
     */
    public static function jr($ref)
    {
        return Args::NS_JAVAROSA . ":" . Elmt::ITEXT . "('$ref')";
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
