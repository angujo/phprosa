<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 3:05 AM
 */

namespace Angujo\PhpRosa\Models;


/**
 * Class FormList
 * @package Angujo\PhpRosa\Models
 *
 */
class Manifest
{
    use TraitGenerator;
    protected $_xmlns = Args::URI_MANIFEST;
    protected $media  = [];
    protected $root   = 'manifest';

    /**
     * @param FormInterface $media_file
     * @return static
     */
    public static function create(FormInterface $media_file)
    {
        return (new static())->addMedia($media_file);
    }

    public function addMedia(FormInterface $media_file)
    {
        $this->media[] = $media_file;
        return $this;
    }
}