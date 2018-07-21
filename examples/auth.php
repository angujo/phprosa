<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-20
 * Time: 6:24 AM
 */


require_once 'example.php';
\Angujo\PhpRosa\Authentication\Access::setRealm('realm');
/*\Angujo\PhpRosa\Authentication\Access::authenticateByPassword(function ($username) {
    return 'does';
});*/
\Angujo\PhpRosa\Authentication\Access::authenticateByHA1(function ($username) {
    return md5('john:'.\Angujo\PhpRosa\Authentication\Access::getRealm().':does');
});

print 'We are here: Congrats!';