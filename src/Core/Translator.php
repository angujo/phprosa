<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-08-02
 * Time: 6:38 AM
 */

namespace Angujo\PhpRosa\Core;


use Angujo\PhpRosa\Form\Translation;

class Translator
{
    /** @var Translation[] */
    private $translations = [];

    public function trans($id, $lang, $content)
    {
        if (!isset($this->translations[$lang])) $this->translations[$lang] = Translation::create($lang);

    }

    public function getTranslation($id)
    {

    }
}