<?php

namespace Blog\Controller;


use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

class AbstractBlogController extends AbstractActionController
{
    public function createForm($entity)
    {
        $sl = $this->getServiceLocator();
        $form = $sl->get('FormElementManager')->get($entity);
        return $form;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}