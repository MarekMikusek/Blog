<?php

namespace Blog\Controller;

use Blog\Form\BlogForm;
use Blog\Model\Blog;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel([
            'blogs' => $this->getEntityManager()->getRepository('Blog\Model\Blog')->findAll()
        ]);
    }

    public function createForm()
    {
        $sl = $this->getServiceLocator();
        $form = $sl->get('FormElementManager')->get('\Blog\Form\Blog');
        return $form;

//        $form = new BlogForm();
//        $form->setHydrator(new ClassMethods())
//            ->setObject(new Blog());
//        return $form;

    }

    public function addAction()
    {
        $form = $this->createForm();
        $form->get('submit')->setValue('add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEntityManager()->persist($form->getData());
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('blog');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('blog', [
                'action' => 'add'
            ]);
        }
        try {
            $blog = $this->getEntityManager()->getRepository('Blog\Model\Blog')->find($id);
        } catch (\Exception $ex) {
            $this->redirect()->toRoute('blog', [
                'action' => 'index'
            ]);
        }
        $form = $this->createForm();
        $form->bind($blog);
        $form->get('submit')->setAttribute('value', 'Save');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('blog');
            }
        }
        return ['form'=>$form];
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('blog');
        }
        $request = $this->getRequest();
        $blog = $this->getEntityManager()->getRepository('Blog\Model\Blog')->find($id);
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $this->getEntityManager()->remove($blog);
                $this->getEntityManager()->flush();
            }
            return $this->redirect()->toRoute('blog');
        }
        return ['blog'=>$blog];
    }

    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}

