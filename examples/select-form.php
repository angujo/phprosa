<?php

/* 
 * PhpRosa: Php for OpenRosa
 * MIT license * 
 */

require './example.php';

global $type;

$gender = Angujo\PhpRosa\Form\Controls\SelectOne::create('Sex', 'sex');
$gender->addOption('2019', 2019);
$gender->addOption('male', 'm')->addTranslation('Mwanaume', 'Kiswahili')->addTranslation('Wuoi', 'Dholuo');
$gender->addOption('Female', 'f')->addTranslation('Mwanamke', 'Kiswahili')->addTranslation('Dhako', 'Dholuo');

$country = \Angujo\PhpRosa\Form\Controls\Select::create('Countries', 'countries');
$country->translateLabel('Dholuo', 'Pinje')->translateLabel('Kiswahili', 'Nchi');
$country->addOption('Nairobi', 'nrb');
$country->addOption('Uganda', 'ug');
$country->addOption('Tanzania', 'tz');

$range = \Angujo\PhpRosa\Form\Controls\Range::create('Ranges', 'rng');
$team1 = \Angujo\PhpRosa\Form\Controls\Range::create('Manchester City', 'manc');
$team2 = \Angujo\PhpRosa\Form\Controls\Range::create('Manchester United', 'manu');
$team3 = \Angujo\PhpRosa\Form\Controls\Range::create('Liverpool', 'lvp');

$group = Angujo\PhpRosa\Form\Controls\Group::create('joker', 'Teams')->singleScreen();
$group->addControl($team1)->addControl($team2)->addControl($team3);

$rank = Angujo\PhpRosa\Form\Controls\Rank::create('Fruits', 'fr');
$rank->addOption('Mango', 'mg');
$rank->addOption('Orange', 'or');

$group2 = \Angujo\PhpRosa\Form\Controls\Group::create('foods', 'Fooder');
$select = \Angujo\PhpRosa\Form\Controls\Select::create('Cuisines', 'cusinie');
$select->addOption('Pilau', 'pli');
$select->addOption('Mchuzi', 'soup');
$group2->addControl($select);


$xform = new \Angujo\PhpRosa\Http\FormEntry();
$xform->setTitle('Select Form');
$xform->setFormDetails('selform101', '1.0.7');

//$xform->addControl($rank);
$xform->addControl($gender);
$xform->addControl($country);
$xform->addControl($range);
$xform->addGroup($group);
$xform->addGroup($group2);

//echo '<pre>';print_r(\Angujo\PhpRosa\Core\Language::all());die;
$xform->response()->xml();
