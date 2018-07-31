<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-14
 * Time: 11:33 AM
 */

namespace Angujo\PhpRosa\Core;


class Session
{
    /** @var Element[] */
    public static $elements = [];
    /** @var array */
    public static $xml_namespaces = [];
    public static $active_holder;
    /** @var array */
    public static $xml_namespaces_holders = [];

    public static $translations=[];
    /** @var string */
    public static $primary_paths=[];
}