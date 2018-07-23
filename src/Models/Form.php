<?php

namespace Angujo\PhpRosa\Models;

use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Util\Elmt;

/**
 * Class Form
 * @package Angujo\PhpRosa\Models
 *
 * @property $formID;
 * @property $name;
 * @property $version;
 * @property $hash;
 * @property $description;
 * @property $downloadURL;
 * @property $manifestUrl;
 */
class Form extends Factory implements FormInterface
{

    use TraitGenerator;

    const ELEMENT = Elmt::FORM;

    protected function __construct($url, $name)
    {
        $this->attributes = [
            'formID',
            'name',
            'version',
            'hash',
            'description',
            'downloadURL',
            'manifestUrl',
        ];
        $this->downloadURL = $url;
        $this->name = $name;
        if (is_array($url)) parent::create($url);
    }

    /**
     * @param null|array|string $url
     * @param null $name
     * @return Form|static
     */
    public static function create($url = null, $name = null)
    {
        return new self($url, $name);
    }

    public function write(Writer $writer)
    {
        $writer->startElement(self::ELEMENT);
        $writer->writeAttribute('url', $this->downloadURL);
        $writer->text($this->name);
        $writer->endElement();
        return $writer;
    }
}
