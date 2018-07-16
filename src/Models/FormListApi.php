<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 3:05 AM
 */

namespace Angujo\PhpRosa\Models;

use Angujo\PhpRosa\Util\Elmt;


/**
 * Class FormListApi
 * @package Angujo\PhpRosa\Models
 *
 */
class FormListApi
{
    use TraitGenerator;

    protected $_xmlns = Args::URI_FORMLIST;
    protected $forms  = [];
    protected $root   = Elmt::FORM_LIST;

    /**
     * @param FormInterface $form
     * @return static
     */
    public static function create(FormInterface $form)
    {
        return (new static())->addForm($form);
    }

    public function addForm(FormInterface $form)
    {
        $this->forms[] = $form;
        return $this;
    }
}