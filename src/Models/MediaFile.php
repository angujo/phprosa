<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 4:10 AM
 */

namespace Angujo\PhpRosa\Models;


use Angujo\PhpRosa\Util\Elmt;

class MediaFile extends Factory implements FormInterface
{
    use TraitGenerator;
    protected $root = Elmt::MEDIA_FILE;
    protected $hash;
    protected $filename;
    protected $downloadUrl;

    protected function __construct() { }
}