<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-22
 * Time: 10:23 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\IdPath;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Util\Elmt;

class TranslationItem
{
    private $id;
    private $value;
    private $path = false;
    private $path_suffix;

    protected function __construct($id, $val)
    {
        $this->id = $id;
        $this->value = $val;
    }

    public static function create($id, $value)
    {
        return new self($id, $value);
    }

    public static function withPath($value, $path_id, $suffix = null)
    {
        $me = self::create($path_id, $value);
        $me->path = true;
        $me->setSuffix($suffix);
        return $me;
    }

    public function setSuffix($suffix)
    {
        $this->path_suffix = $suffix;
        return $this;
    }

    public function write(Writer $writer)
    {
        if (!$this->id) return $writer;
        $ref = ($this->path ? IdPath::getPath($this->id)->fullPath() : $this->id) . ($this->path_suffix ? ':' . $this->path_suffix : '');
        $writer->startElement(Elmt::TEXT);
        $writer->writeAttribute('id', $ref);
        $writer->writeElement(Elmt::VALUE, $this->value);
        $writer->endElement();
        return $writer;
    }
}