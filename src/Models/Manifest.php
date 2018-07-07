<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 3:05 AM
 */

namespace PhpRosa\Models;


/**
 * Class FormList
 * @package PhpRosa\Models
 *
 */
class Manifest
{
    use TraitGenerator;
    protected $_xmlns = Args::OPENROSA_MANIFEST;
    protected $media  = [];
    protected $root   = 'xforms';

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