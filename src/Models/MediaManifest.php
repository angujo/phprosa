<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 3:05 AM
 */

namespace Angujo\PhpRosa\Models;


/**
 * Class FormListApi
 * @package Angujo\PhpRosa\Models
 *
 */
class MediaManifest
{
    use TraitGenerator;

    protected $xmlns = Args::URI_MANIFEST;
    const ELEMENT = 'manifest';

    protected function __construct()
    {
        $this->attributes = [Args::XMLNS];
    }

    /**
     * @param MediaFile $media_file
     * @return static
     */
    public static function create(MediaFile $media_file)
    {
        return (new static())->addMedia($media_file);
    }

    public function addMedia(MediaFile $media_file)
    {
        $this->children[] = $media_file;
        return $this;
    }
}