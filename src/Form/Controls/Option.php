<?php

/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:27 AM
 */

namespace Angujo\PhpRosa\Form\Controls;

use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Form\Item;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

class Option extends Item
{

    private $text;

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
        $translation = $me->addNode(Elmt::LABEL, $name, $translate);
        $me->addNode(Elmt::VALUE, $value);
        return $me;
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
