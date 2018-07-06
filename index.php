<?php

require 'autoload.php';

$form=new PhpRosa\Models\Form();
$form->description='For testing';
$writer=new XMLWriter();
$writer->openMemory();
$writer->startDocument();
$form->xml($writer);
$writer->endDocument();

echo '<pre>';
print_r ($writer->outputMemory(TRUE));