<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-15
 * Time: 5:30 PM
 */

namespace Angujo\PhpRosa\Http;


use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\FormListApi;
use Angujo\PhpRosa\Models\TraitOutput;

/**
 * Class FormList
 * @package Angujo\PhpRosa\Http
 *
 * @inheritdoc
 *
 */
class FormList extends FormListApi
{
    use TraitOutput;
}