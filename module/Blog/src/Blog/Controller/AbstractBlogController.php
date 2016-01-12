<?php
/**
 * Created by PhpStorm.
 * User: Konto
 * Date: 2016-01-12
 * Time: 10:45
 */

namespace Blog\Controller;


use Zend\Mvc\Controller\AbstractActionController;

class AbstractBlogController extends AbstractActionController
{
    public function createForm(){
        $sl = $this->getServiceLocator();
        $form=$sl->get('FormElementManager')->get();
        return $form;
    }

}