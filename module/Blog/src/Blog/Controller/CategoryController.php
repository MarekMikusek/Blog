<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2015-12-23
 * Time: 12:34
 */

namespace Blog\Controller;

use Blog\Form\CategoryForm;
use Blog\Model\Category;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;


class CategoryController extends AbstractActionController
{

    public function createForm()
    {
        $form = new CategoryForm();
        $form->setHydrator(new ClassMethods())
            ->setObject(new Category());
        return $form;
    }

    public function addAction()
    {
        $form = $this->createForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEntityManager()->persist($form->getData());
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('blog');
            }
        }

        return ['form' => $form];
    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }

    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}