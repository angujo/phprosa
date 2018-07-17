<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-16
 * Time: 7:16 AM
 */

namespace Angujo\PhpRosa\Http;


use Angujo\PhpRosa\Core\TraitArray;
use Angujo\PhpRosa\Models\MediaManifest;
use Angujo\PhpRosa\Models\TraitOutput;

class Manifest extends MediaManifest
{
    use TraitOutput, TraitArray;

    public function __construct()
    {
        parent::__construct();
        $this->for_array = 'children';
    }
}