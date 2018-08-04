<?php

/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:27 AM
 */

namespace Angujo\PhpRosa\Form\Controls;

use Angujo\PhpRosa\Core\Language;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Item;
use Angujo\PhpRosa\Form\ItemNode;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

class Option extends Item
{

    private $text;
    private $suffix;
    private $path_id;
    /** @var ItemNode */
    private $details;

    /**
     * @param $name
     * @param null|string $value
     * @param bool $translate
     * @param null $translation
     * @return Option|Item
     */
    public static function create($name, $value = null, $translate = false, &$translation = null)
    {
        $me = new self(null);
        $me->text = $name;
        $me->details = $me->addNode(Elmt::LABEL, $name);
        $me->addNode(Elmt::VALUE, $value);
        return $me;
    }

    public function setDetails($path, $suffix)
    {
        $this->path_id = $path;
        $this->suffix = $suffix;
        if ($this->path_id && Language::translatable($this->text)) $this->details->pathDetails($this->path_id, $this->suffix);
        $this->addTranslation($this->text);
        return $this;
    }

    public function addTranslation($name, $lang = Args::DEF_LANG)
    {
        if (!$this->path_id || !Language::translatable($this->text)) return $this;
        Language::suffixedPath($this->path_id, $name,$this->suffix, $lang);
        return $this;
    }

    /**
     * @param Writer $writer
     * @param string $reference
     * @return Writer
     */
    /* public function write(Writer $writer,$ref=null)
      {
      if (empty($this->nodes)) return $writer;
      $writer->startElement(Elmt::ITEM);
      if (null !== $this->id) $writer->writeElement($this->itext, $this->id);
      foreach ($this->nodes as $name => $value) {
      $writer->writeElement($name, $value);
      }
      $writer->endElement();
      return $writer;
      } */
}
