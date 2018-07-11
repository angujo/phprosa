<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-11
 * Time: 6:59 AM
 */

namespace PhpRosa\Form\Controls;


use PhpRosa\Form\Control;

class Upload extends Control
{
    private $types = [];
    private $auto  = false;

    public static function image($label, $name)
    {
        $me = new self($label, $name);
        $me->types[] = 'image/*';
        return $me;
    }

    public static function document($label, $name)
    {
        $me = new self($label, $name);
        $me->types[] = 'application/pdf';
        $me->types[] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        $me->types[] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.template';
        $me->types[] = 'application/msword';
        $me->types[] = 'application/vnd.ms-word.document.macroenabled.12';
        $me->types[] = 'application/vnd.ms-word.template.macroenabled.12';
        return $me;
    }

    public static function video($label, $name)
    {
        $me = new self($label, $name);
        $me->types[] = 'video/*';
        return $me;
    }

    public static function audio($label, $name)
    {
        $me = new self($label, $name);
        $me->types[] = 'audio/*';
        return $me;
    }

    private function autoType()
    {
        $this->auto = true;
        return $this;
    }

    public static function file($label, $name)
    {
        return (new self($label, $name))->autoType();
    }

    public function addMime($mime)
    {
        if (!$this->auto) return;
        $this->types[] = $mime;
    }

    public function xml(\XMLWriter $writer)
    {
        $this->attributes['mediatype'] = implode(',', $this->types);
        return parent::xml($writer, null);
    }
}