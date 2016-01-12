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