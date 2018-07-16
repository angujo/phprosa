<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-15
 * Time: 5:10 PM
 */

header('Content-Type: xml\text;charset:utf');

include 'form-example.php';

global $xform;

print $xform->xml();