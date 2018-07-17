<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 3:05 AM
 */

namespace Angujo\PhpRosa\Models;

use Angujo\PhpRosa\Core\TraitArray;
use Angujo\PhpRosa\Util\Elmt;


/**
 * Class FormListApi
 * @package Angujo\PhpRosa\Models
 *
 */
class FormListApi
{
    use TraitGenerator, TraitArray;

    protected $_xmlns = Args::URI_FORMLIST;
    const ELEMENT = Elmt::FORM_LIST;

    protected function __construct() { $this->for_array = ['children']; }

    /**
     * @param Form $form
     * @return static
     */
    public static function create(Form $form)
    {
        return (new static())->addForm($form);
    }

    public function addForm(Form $form)
    {
        return $this->formInterfacing($form);
    }

    protected function formInterfacing(FormInterface $form)
    {
        $this->children[] = $form;
        return $this;
    }

    public function addFormGroup(FormGroup $formGroup)
    {
        return $this->formInterfacing($formGroup);
    }
}