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
    const LABEL = 'label';
    const VALUE = 'value';
    private $translations = [];
    private $text;

    public static function create($name, $value = null)
    {
        $me = new self(null);
        $me->text = $name;
        $me->addTranslation($me->text);
        $name = null;
        $me->addNode(self::LABEL, $name);
        $me->addNode(self::VALUE, $value);
        return $me;
    }

    public function addTranslation($label, $lang = Args::DEF_LANG)
    {
        $this->translations[$lang] = $label;
        return $this;
    }

    /**
     * @param Writer $writer
     * @param string $reference
     * @return Writer
     */
    public function write(Writer $writer)
    {
        if (empty($this->nodes) || !($ref = func_get_arg(2))) return $writer;
        $writer->startElement(Elmt::ITEM);
        if (null !== $this->id) $writer->writeElement($this->itext, $this->id);
        foreach ($this->nodes as $name => $value) {
            $writer->writeElement($name, $value);
        }
        $writer->endElement();
        return $writer;
    }
}