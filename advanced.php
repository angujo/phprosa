<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-14
 * Time: 12:05 PM
 */

require_once 'src\autoload.php';
require_once 'vendor\autoload.php';

header('Content-Type: xml\text;charset:utf');
$faker = Faker\Factory::create();

$text=\Angujo\PhpRosa\Form\Controls\Input::create('This is a text input!','data/text');
$text->required=true;
$text->required_msg='Ensure this field has entry!';
$xform = new \Angujo\PhpRosa\Builder\XForm();
$xform->addControl($text);


print $xform->xml();