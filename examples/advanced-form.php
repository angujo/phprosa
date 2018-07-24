<?php

/* 
 * PhpRosa: Php for OpenRosa
 * MIT license * 
 */

require 'example.php';

global  $type;
$meta=new \Angujo\PhpRosa\Form\MetaData();
$meta->instanceID=true;
        
$decimal = \Angujo\PhpRosa\Form\Controls\Input::decimal('Decimal Type', 'dec');
$datetime = \Angujo\PhpRosa\Form\Controls\Input::dateTime('Date and Time', 'dtime');
$date = \Angujo\PhpRosa\Form\Controls\Input::date('Date Only', 'dated');
$time = \Angujo\PhpRosa\Form\Controls\Input::time('Time Only', 'timed');
$geopoint = \Angujo\PhpRosa\Form\Controls\Input::geopoint('Geopoint', 'geopt');
$geotrace = \Angujo\PhpRosa\Form\Controls\Input::geotrace('Geotrace', 'getraced');
$bool = \Angujo\PhpRosa\Form\Controls\Input::boolean('Boolean', 'booled');
$barcode = \Angujo\PhpRosa\Form\Controls\Input::barcode('Barcoded', 'barc');
$str = \Angujo\PhpRosa\Form\Controls\Input::string('Stringed', 'str');
$integer = \Angujo\PhpRosa\Form\Controls\Input::integer('Integered', 'ing');
$int = \Angujo\PhpRosa\Form\Controls\Input::int('Int Abbr', 'ints');
$url = \Angujo\PhpRosa\Form\Controls\Input::url('URL Link', 'linked');
$email = \Angujo\PhpRosa\Form\Controls\Input::email('Emailed', 'e-mail');

$xform=new \Angujo\PhpRosa\Http\FormEntry();
$xform->setMeta($meta);
$xform->setTitle('Another Form');
$xform->setFormDetails('form102', '1.0.1');
$xform->addControl($decimal);
$xform->addControl($datetime);
$xform->addControl($date);
$xform->addControl($time);
$xform->addControl($geopoint);
$xform->addControl($geotrace);
$xform->addControl($bool);
$xform->addControl($barcode);
$xform->addControl($str);
$xform->addControl($integer);
$xform->addControl($int);
$xform->addControl($url);
$xform->addControl($email);

print $xform->response()->xml();