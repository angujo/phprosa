<?php

require 'autoload.php';

header('Content-Type: xml\text;charset:utf');

$form= \PhpRosa\Models\Form::create(['formID'=>'myform','description'=>'Something small','allwd'=>'Just OK']);
$form2= \PhpRosa\Models\Form::create(['formID'=>'myform343','description'=>'Something small','allwd'=>'Just OK']);
$forms=\PhpRosa\Models\FormList::create($form);$forms->addForm($form2);
$group=\PhpRosa\Models\FormGroup::create(['groupID'=>uniqid('hshs',false),'name'=>'GroupName']);
$forms->addForm($group);
$writer=new XMLWriter();
$writer->openMemory();
$writer->startDocument();
$forms->xml($writer);
$writer->endDocument();

print_r ($writer->outputMemory(TRUE));