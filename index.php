<?php

require 'src\autoload.php';
require 'vendor\autoload.php';

header('Content-Type: xml\text;charset:utf');
$faker = Faker\Factory::create();
/*
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

/*$meta = new \PhpRosa\Form\MetaData();
$meta->email = true;
$meta->instanceID = true;

$instance = \PhpRosa\Form\Instance::create($faker->slug, 'data');
$instance->setPrimary();
$instance->version = $faker->date('YmdHis');
$instance->addFieldName('firstname');
$instance->addFieldName('lastname');
$instance->addFieldName('othername');
$instance->addFieldName('age', 'adults', 90);
$instance->setMeta($meta);*/

$instance=\PhpRosa\Form\Instance::create($faker->slug(1));
$items=\PhpRosa\Form\ItemsList::create('root');
for ($i=0;$i<5;$i++){
    $item=\PhpRosa\Form\Item::create($faker->slug(1));
    $item->addNode('country',$faker->country);
    $item->addNode('code',$faker->countryCode);
    $items->addItem($item);
}
$instance->setItemsList($items);

$writer = new XMLWriter();
$writer->openMemory();
$writer->startDocument();
$instance->xml($writer);
//$response=\PhpRosa\Models\Response::simpleResponse($writer,'Form received successfully!');
$writer->endDocument();

print_r($writer->outputMemory(TRUE));