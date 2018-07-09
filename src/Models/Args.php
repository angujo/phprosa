<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 2:57 AM
 */

namespace PhpRosa\Models;


class Args
{
    const OPENROSA_FORMLIST = 'http://openrosa.org/xforms/xformsList';
    const OPENROSA_MANIFEST = 'http://openrosa.org/xforms/xformsManifest';
    const OPENROSA_RESPONSE = 'http://openrosa.org/http/response';

    const W3_XFORMS         = 'http://www.w3.org/2002/xforms';
    const W3_XHTML          = 'http://www.w3.org/1999/xhtml';
    const W3_XMLSCHEMA      = 'http://www.w3.org/2001/XMLSchema';
    const OPENROSA_JAVAROSA = 'http://openrosa.org/javarosa';
    const OPENROSA_XFORMS   = 'http://openrosa.org/xforms';
    const ODK_XFORMS        = 'http://opendatakit.org/xforms';

    const ELMT_HTML     = 'h';
    const ELMT_JAVAROSA = 'jr';
    const ELMT_ROSAFORM = 'orx';
    const ELMT_ODKFORM  = 'odk';
    const ELMT_XSD      = 'xsd';
    const XMLNS         = 'xmlns';
}