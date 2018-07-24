<?php

/*
 * PhpRosa: Php for OpenRosa
 * MIT license * 
 */

namespace Angujo\PhpRosa\Form;

use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;

/**
 * Description of ItemNode
 *
 * @author bangujo
 */
class ItemNode {

    private $element;
    private $content;
    private $translations = [];
    private $trans = false;

    protected function __construct($elmt, $cnt, $t = false) {
        $this->element = $elmt;
        $this->content = $cnt;
        $this->translations[Args::DEF_LANG] = $cnt;
        $this->trans = $t;
    }

    public static function create($elmt, $content, $translatable = false) {
        return new self($elmt, $content, $translatable);
    }

    /**
     * Add a language translation
     * @param type $content
     * @param type $lang
     * @return $this
     */
    public function addTranslation($content, $lang) {
        $this->translations[$lang] = $content;
        return $this;
    }

    public function translate($reference) {
        if(!$this->trans)            return;
        foreach ($this->translations as $lang => $cnt) {
            Itext::translate($reference, $cnt, $lang);
        }
    }

    /**
     * 
     * @param Writer $writer
     * @param type $reference
     * @return Writer
     */
    public function write(Writer $writer, $reference = null) {
        $writer->startElement($this->element);
        if ($reference && !empty($this->translations) && $this->trans) {
            $writer->writeAttribute('ref', Itext::jr($reference));
        } else {
            $writer->text($this->content);
        }
        $writer->endElement();
        return $writer;
    }

}
