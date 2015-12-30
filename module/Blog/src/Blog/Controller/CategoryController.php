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
use Zend\View\Model\ViewModel;


class CategoryController extends AbstractActionController
{

    public function createForm()
    {
        $form = new CategoryForm();
        $form->setHydrator(new ClassMethods())
            ->setObject(new Category());
        return $form;
    }

    public function indexAction()
    {
        return new ViewModel([
            'categories' => $this->getEntityManager()->getRepository('Blog\Model\Category')->findAll()
        ]);
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
                return $this->redirect()->toRoute('category');
            }
        }

        return ['form' => $form];
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('category', ['action' => 'add']);
        }
        try {
            $category = $this->getEntityManager()->getRepository('Blog\Model\Category')->find($id);
        } catch (\Exception $ex) {
            $this->redirect()->toRoute('category', [
                'action' => 'index'
            ]);
        }
        $form = $this->createForm();
        $form->bind($category);
        $form->get('submit')->setAttribute('value', 'Save');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEntityManager()->flush();
                $this->redirect()->toRoute('Category', ['action' => 'index']);
            }
        }
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('category', ['action' => 'index']);
        }
        $request = $this->getRequest();
        $category = $this->getEntityManager()->getRepository('Blog\Model\Category')->find($id);
        if ($request->isPost) {
            $del = $request->get('del', 'No');
            if ('del' == "Yes") {
                $id = (int)$request->getPost('id');
                $this->getEntityManager()->remove($category);
                $this->getEntityManager()->flush();
            }
        }
        return ['category'=>$category];
    }

    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}