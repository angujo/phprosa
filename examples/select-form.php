<?php

/* 
 * PhpRosa: Php for OpenRosa
 * MIT license * 
 */

require './example.php';

global $type;

$gender= Angujo\PhpRosa\Form\Controls\SelectOne::create('Sex', 'sex');
$gender->addOption('male', 'm');
$gender->addOption('Female', 'f');

$country= \Angujo\PhpRosa\Form\Controls\Select::create('Countries', 'countries');
$country->addOption('Nairobi', 'nrb');
$country->addOption('Uganda', 'ug');
$country->addOption('Tanzania', 'tz');

$range= \Angujo\PhpRosa\Form\Controls\Range::create('Ranges', 'rng');
$team1= \Angujo\PhpRosa\Form\Controls\Range::create('Manchester City', 'manc');
$team2= \Angujo\PhpRosa\Form\Controls\Range::create('Manchester United', 'manu');
$team3= \Angujo\PhpRosa\Form\Controls\Range::create('Liverpool', 'lvp');

$group= Angujo\PhpRosa\Form\Controls\Group::create(null,'Teams')->singleScreen();
$group->addControl($team1)->addControl($team2)->addControl($team3);

$rank= Angujo\PhpRosa\Form\Controls\Rank::create('Fruits', 'fr');
$rank->addOption('Mango', 'mg');$rank->addOption('Orange', 'or');


$xform=new \Angujo\PhpRosa\Http\FormEntry();
$xform->setTitle('Select Form');
$xform->setFormDetails('selform101', '1.0.7');

//$xform->addControl($rank);
$xform->addControl($gender);
$xform->addControl($country);
$xform->addControl($range);
$xform->addGroup($group);

$xform->response()->xml();
