<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-22
 * Time: 9:47 AM
 */

namespace Angujo\PhpRosa\Form;


use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Util\Elmt;

class Translation
{
    /** @var TranslationItem[] */
    private $items = [];
    private $lang  = Args::DEF_LANG;

    public function __construct($name = Args::DEF_LANG)
    {
        $this->lang = $name;
    }

    public static function create($lang)
    {
        return new self($lang);
    }

    public function addItem($id, $text)
    {
        $this->items[md5($id)] = TranslationItem::create($id, $text);
        return $this;
    }

    public function getItem($id)
    {

    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    public function write(Writer $writer)
    {
        //var_dump($this->items);die;
        $writer->startElement(Elmt::TRANSLATION);
        if (0 === strcmp(Args::DEF_LANG, $this->lang)) $writer->writeAttribute('default', 'true()');
        $writer->writeAttribute('lang', $this->lang);
        foreach ($this->items as $item) {
            $item->write($writer);
        }
        $writer->endElement();
    }
}