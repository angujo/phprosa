<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-08-04
 * Time: 6:44 AM
 */

namespace Angujo\PhpRosa\Core;


use Angujo\PhpRosa\Util\Elmt;

class Translation
{
    /** @var string */
    private $path_id;
    /** @var string */
    private $suffix;
    /** @var string */
    private $content;

    protected function __construct($path, $content)
    {
        $this->path_id = $path;
        $this->content = $content;
    }

    /**
     * @param $path string
     * @param $content string
     * @param null|string $suffix
     * @return Translation
     */
    public static function create($path, $content, $suffix = null)
    {
        $me = new self($path, $content);
        return $me->setSuffix($suffix);
    }

    /**
     * @param string $suffix
     * @return Translation
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    public function getId()
    {
        return md5($this->path_id . $this->suffix);
    }

    public function ignore()
    {
        return !Language::translatable($this->content);
    }

    private function reference()
    {
        return IdPath::getPath($this->path_id)->referencePath() . ($this->suffix ? ':' . $this->suffix : '');
    }

    public function write(Writer $writer)
    {
        $writer->startElement(Elmt::TEXT);
        $writer->writeAttribute('id', $this->reference());
        $writer->writeElement(Elmt::VALUE, $this->content);
        $writer->endElement();
    }
}