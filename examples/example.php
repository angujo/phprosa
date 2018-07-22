<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-16
 * Time: 7:47 PM
 */


$type = isset($_GET['type']) ? $_GET['type'] : 'xml';

require_once '../src/autoload.php';
require_once '../vendor/autoload.php';


$faker = Faker\Factory::create();
$faker->seed(12345);

\Angujo\PhpRosa\Authentication\Access::authenticateByHA1(function ($username) {
    return md5('john:'.\Angujo\PhpRosa\Authentication\Access::getRealm().':does');
});

function getBaseUrl()
{
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF'];

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
    $pathInfo = pathinfo($currentPath);

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST'];

    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

    // return: http://localhost/myproject/
    return $protocol.'://'.$hostName.$pathInfo['dirname']."/";
}