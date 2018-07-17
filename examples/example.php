<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-16
 * Time: 7:47 PM
 */


$type = isset($_GET['type']) ? $_GET['type'] : 'xml';

require_once '../src\autoload.php';
require_once '../vendor/autoload.php';


$faker = Faker\Factory::create();
$faker->seed(12345);