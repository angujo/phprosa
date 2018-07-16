<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-15
 * Time: 5:10 PM
 */

header('Content-Type: application/json;charset:utf');

include 'form-example.php';

global $xform;

print json_encode($xform->json_array()) ;