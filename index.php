<?php

require 'autoload.php';

$form= \PhpRosa\Models\Form::create(['formID'=>'myform','description'=>'Something small','allwd'=>'Just OK']);
$writer=new XMLWriter();
$writer->openMemory();
$writer->startDocument();
$form->xml($writer);
$writer->endDocument();

echo '<pre>';
print_r ($writer->outputMemory(TRUE));