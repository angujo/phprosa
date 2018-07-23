<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-14
 * Time: 12:05 PM
 */

require 'example.php';

global $type;

$meta=new \Angujo\PhpRosa\Form\MetaData();
$meta->instanceID=true;

$text = \Angujo\PhpRosa\Form\Controls\Input::create('This is a text input!', 'textui');
$text->required = true;
$text->required_msg = 'Ensure this field has entry!';
$text->readonly = true;

$email = \Angujo\PhpRosa\Form\Controls\Input::email('Email Address', 'e-mail');
$decimal = \Angujo\PhpRosa\Form\Controls\Input::decimal('Amount', 'decimal');
$date = \Angujo\PhpRosa\Form\Controls\Input::datetime('Today?', 'dated');
$date->setDefaultValue(date('Y-m-d H:i:s'));

$gender = \Angujo\PhpRosa\Form\Controls\SelectOne::create('Sex', 'gender');
$gender->addOption('Male', 'm')->addOption('Female', 'f');

$cities = \Angujo\PhpRosa\Form\Controls\Select::create('Cities', 'cities');
$cities->required = true;
looper(function ($i) use ($cities, $faker) {
    $cities->addOption($faker->city, $faker->citySuffix);
}, 8);

$range = \Angujo\PhpRosa\Form\Controls\Range::create('How do you rate us?', 'rates');

$rank = \Angujo\PhpRosa\Form\Controls\Rank::create('Favourite country', 'countries');
looper(function ($i) use ($rank, $faker) {
    $rank->addOption($faker->country, $faker->countryCode);
});
$rank->setDefaultValue($faker->countryCode);

$doc = \Angujo\PhpRosa\Form\Controls\Upload::document('Upload your CV', 'cv');

$video=\Angujo\PhpRosa\Form\Controls\Upload::video('Event Video','evt');
$audio=\Angujo\PhpRosa\Form\Controls\Upload::audio('Event Audio','aud');

$xform = new \Angujo\PhpRosa\Http\FormEntry();
$xform->setMeta($meta);
$xform->addControl($date);
$xform->addControl($email);
$xform->addControl($decimal);

$xform->addControl($doc);
$xform->addControl($video);
$xform->addControl($gender);
$xform->addControl($cities);
$xform->addControl($rank);
$xform->addControl($range);
$xform->addControl($audio);
$xform->startGroup();
$xform->startRepeat();
$xform->startGroup();
$xform->addControl($text);
$xform->endGroup();
$xform->endRepeat();
$xform->endGroup();



function looper(Closure $closure, $limit = 10)
{
    for ($i = 0; $i < $limit; $i++) {
        $closure($i);
    }
}

if ('xml' === $type) $xform->response()->xml();
else $xform->response()->array_json();

