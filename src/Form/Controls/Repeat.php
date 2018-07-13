<?php
/**
 * Created for Angujo-PhpRosa.
 * User: Angujo Barrack
 * Date: 2018-07-13
 * Time: 3:23 AM
 */

namespace Angujo\PhpRosa\Form\Controls;


use Angujo\PhpRosa\Core\Attribute;
use Angujo\PhpRosa\Core\Writer;
use Angujo\PhpRosa\Models\Args;

class Repeat extends ControlCollection
{
    const ELEMENT = 'repeat';
    private $count;
    private $noAddRemove;

    /**
     * @param int $count
     * @return Repeat
     */
    public function setCount($count)
    {
        $this->count = is_numeric($count) ? (int)$count : null;
        return $this;
    }

    public function noAddRemove()
    {
        $this->noAddRemove = 'true()';
        return $this;
    }

    private function setAddRemove()
    {
        if (!$this->noAddRemove) return;
        $attr = new Attribute('noAddRemove', Args::NS_JAVAROSA, Args::URI_JAVAROSA);
        $attr->setContent($this->noAddRemove);
        $this->attributes[] = $attr;
    }

    private function setCounter()
    {
        if (!$this->count) return;
        $attr = new Attribute('count', Args::NS_JAVAROSA, Args::URI_JAVAROSA);
        $attr->setContent($this->count);
        $this->attributes[] = $attr;
    }

    public function write(Writer $writer)
    {
        $this->setAddRemove();
        $this->setCounter();
       return parent::write($writer);
    }

}