<?php

/*
 * PhpRosa: Php for OpenRosa
 * MIT license * 
 */

namespace Angujo\PhpRosa\Form;

use Angujo\PhpRosa\Core\IdPath;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;

/**
 * Description of ItemNode
 *
 * @author bangujo
 */
class ItemNode
{

    private $element;
    private $content;
    private $path_id;
    private $suffix;

    protected function __construct($elmt, $cnt, $t = false)
    {
        $this->element = $elmt;
        $this->content = $cnt;
    }

    public static function create($elmt, $content, $translatable = false)
    {
        return new self($elmt, $content, $translatable);
    }

    public function pathDetails($id, $suffix = null)
    {
        $this->path_id = $id;
        $this->suffix = $suffix;
        return $this;
    }

    /**
     *
     * @param Writer $writer
     * @param string $reference
     * @return Writer
     */
    public function write(Writer $writer, $reference = null)
    {
        $writer->startElement($this->element);
        if ($this->path_id && IdPath::hasPath($this->path_id)) {
            $writer->writeAttribute('ref', Itext::jr(IdPath::getPath($this->path_id)->referencePath() . ($this->suffix ? ':' . $this->suffix : '')));
        }
        /*if ($reference && !empty($this->translations) && $this->trans) {
            $writer->writeAttribute('ref', Itext::jr($reference));
        }*/ else {
            $writer->text($this->content);
        }
        $writer->endElement();
        return $writer;
    }

}
