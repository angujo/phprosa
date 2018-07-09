<?php
/**
 * Created by PhpStorm.
 * User: Angujo Barrack
 * Date: 2018-07-07
 * Time: 3:05 AM
 */

namespace PhpRosa\Models;


/**
 * Class FormList
 * @package PhpRosa\Models
 *
 */
class FormList
{
    use TraitGenerator;
    protected $_xmlns = Args::OPENROSA_FORMLIST;
    protected $forms  = [];
    protected $root   = 'xforms';

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