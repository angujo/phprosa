<?php

require 'src\autoload.php';
require 'vendor\autoload.php';

header('Content-Type: xml\text;charset:utf');
/*$faker=Faker\Factory::create();

$form= \PhpRosa\Models\Form::create(['formID'=>$faker->md5,'description'=>$faker->sentence,'allwd'=>'Just OK']);
$form2= \PhpRosa\Models\Form::create(['formID'=>'myform343','description'=>'Something small','allwd'=>'Just OK']);
$forms=\PhpRosa\Models\FormList::create($form);$forms->addForm($form2);
$group=\PhpRosa\Models\FormGroup::create(['groupId'=>uniqid('hshs',false),'name'=>'GroupName']);

$m1=\PhpRosa\Models\MediaFile::create(['filename'=>$faker->slug.'.'.$faker->fileExtension,'downloadUrl'=>$faker->url,'hash'=>$faker->md5]);
$manifest=\PhpRosa\Models\Manifest::create($m1);
for ($i=0;$i<5;$i++){
    $media=\PhpRosa\Models\MediaFile::create(['filename'=>$faker->slug.'.'.$faker->fileExtension,'downloadUrl'=>$faker->url,'hash'=>$faker->md5]);
    $manifest->addMedia($media);
}
$forms->addForm($group);
//$manifest->xml($writer);

$bind=new \PhpRosa\Form\Bind();
$bind->nodeset='/data/fname';
$bind->type='number';
$bind->calculate='[2323]+3434';*/

$meta=new \PhpRosa\Form\MetaData();
$meta->email=true;
$meta->instanceID=true;

$writer=new XMLWriter();
$writer->openMemory();
$writer->startDocument();
$meta->xml($writer);
//$response=\PhpRosa\Models\Response::simpleResponse($writer,'Form received successfully!');
$writer->endDocument();

print_r ($writer->outputMemory(TRUE));