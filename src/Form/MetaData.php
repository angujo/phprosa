<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-10
 * Time: 5:49 AM
 */

namespace Angujo\PhpRosa\Form;

use Angujo\PhpRosa\Models\Args;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Util\Elmt;

/**
 * Class MetaData
 * @package Angujo\PhpRosa\Form
 *
 * @property bool $instanceID;
 * @property bool $timeStart;
 * @property bool $timeEnd;
 * @property bool $userID;
 * @property bool $deviceID;
 * @property bool $deprecatedID;
 * @property bool $email;
 * @property bool $phoneNumber;
 * @property bool $simSerial;
 * @property bool $subscriberID;
 * @property bool $audit;
 */
class MetaData
{
    private $attributes = [
        'instanceID',
        'timeStart',
        'timeEnd',
        'userID',
        'deviceID',
        'deprecatedID',
        'email',
        'phoneNumber',
        'simSerial',
        'subscriberID',
        'audit',
    ];

    private $set = [];

    public function __get($property)
    {
        $this->valid($property);
        return in_array($property, $this->set, false);
    }

    public function __isset($property)
    {
        $this->valid($property);
        return in_array($property, $this->set, false);
    }

    public function __set($property, $value)
    {
        $this->valid($property);
        if (in_array($property, $this->set, false)) unset($this->set[array_search($property, $this->set, false)]);
        if ((is_bool($value) && true === $value) || (is_string($value) && strcmp('true', $value) === 0) || (is_numeric($value) && $value > 0)) {
            $this->set[] = $property;
        }
    }

    public function write(Writer $writer)
    {
        $writer->startElementNs(Args::NS_ROSAFORM, Elmt::META, Args::URI_ROSAFORM);
        foreach ($this->set as $item) {
            $writer->writeElementNs(Args::NS_ROSAFORM, $item, null,null);
        }
        $writer->endElement();
    }

    private function valid($property)
    {
        if (!in_array($property, $this->attributes, true)) throw new \RuntimeException("'$property' is invalid!");
    }
}