<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-16
 * Time: 6:21 PM
 */

require 'example.php';

global $type;

$faker = Faker\Factory::create();
$form1 = \Angujo\PhpRosa\Models\Form::create();
$form1->formID = $faker->slug(2);
$form1->name = $faker->slug(1);
$form1->version = $faker->slug;

$form2 = \Angujo\PhpRosa\Models\Form::create();
$form2->formID = $faker->slug(2);
$form2->name = $faker->slug(1);
$form2->version = $faker->slug;

$group = \Angujo\PhpRosa\Models\FormGroup::create();
$group->name = $faker->slug();
$group->descriptionText = $faker->sentence;
$group->descriptionUrl = $faker->url;
$group->listUrl = $faker->url;

$form_g2 = \Angujo\PhpRosa\Models\Form::create();
$form_g2->formID = $faker->slug(2);
$form_g2->name = $faker->slug(1);
$form_g2->version = $faker->slug;

$list = \Angujo\PhpRosa\Http\FormList::create($form1);
$list->addForm($form2);
$list->addFormGroup($group);
$list->addForm($form_g2);

if ('xml' === $type) $list->response()->xml();
else $list->response()->array_json();
