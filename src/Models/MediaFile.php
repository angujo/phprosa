<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 4:10 AM
 */

namespace Angujo\PhpRosa\Models;


use Angujo\PhpRosa\Core\TraitArray;
use Angujo\PhpRosa\Util\Elmt;

/**
 * Class MediaFile
 * @package Angujo\PhpRosa\Models
 *
 * @property $hash
 * @property $filename
 * @property $downloadUrl
 *
 */
class MediaFile extends Factory implements FormInterface
{
    use TraitGenerator, TraitArray;
    const ELEMENT = Elmt::MEDIA_FILE;

    protected function __construct() { $this->attributes = ['hash', 'filename', 'downloadUrl'];$this->for_array='children'; }
}