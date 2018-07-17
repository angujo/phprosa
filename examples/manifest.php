<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-16
 * Time: 8:07 PM
 */

require 'example.php';

global $type, $faker;

$media = \Angujo\PhpRosa\Models\MediaFile::create();
$media->hash = $faker->md5;
$media->downloadUrl = $faker->imageUrl();
$media->filename = $faker->slug(1) . '.' . $faker->fileExtension;

$media1 = \Angujo\PhpRosa\Models\MediaFile::create();
$media1->hash = $faker->md5;
$media1->downloadUrl = $faker->imageUrl();
$media1->filename = $faker->slug(1) . '.' . $faker->fileExtension;

$media2 = \Angujo\PhpRosa\Models\MediaFile::create();
$media2->hash = $faker->md5;
$media2->downloadUrl = $faker->imageUrl();
$media2->filename = $faker->slug(1) . '.' . $faker->fileExtension;

$manifest = \Angujo\PhpRosa\Http\Manifest::create($media);
$manifest->addMedia($media1)->addMedia($media2);

if ($type === 'xml') $manifest->response()->xml();
else $manifest->response()->array_json();