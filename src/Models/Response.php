<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 8:26 AM
 */

namespace Angujo\PhpRosa\Models;


class Response
{
    const ROSA_ENVELOPE = 'OpenRosaResponse';

    public static function simpleResponse(\XMLWriter $xmlWriter, $message)
    {
        $xmlWriter->startElement(self::ROSA_ENVELOPE);
        $xmlWriter->writeAttribute('xmlns', Args::OPENROSA_RESPONSE);
        $xmlWriter->writeElement('message', $message);
        $xmlWriter->endElement();
        return $xmlWriter;
    }
}