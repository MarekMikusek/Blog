<?php

namespace Blog\Controller;

use Blog\Form\PostForm;
use Blog\Model\Post;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;

class MainPageController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->getEntityManager()->getRepository('Blog\Model\Post')
                ->findBy([])
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

//    public function addAction()
//    {
//        $form = $this->createForm();
//        $form->get('submit')->setValue('add');
//
//        $request = $this->getRequest();
//        if ($request->isPost()) {
//            $form->setData($request->getPost());
//            if ($form->isValid()) {
//                $this->getEntityManager()->persist($form->getData());
//                $this->getEntityManager()->flush();
//                return $this->redirect()->toRoute('post');
//            }
//        }
//        return array('form' => $form);
//    }
//
//    public function editAction()
//    {
//        $id = (int)$this->params()->fromRoute('id', 0);
//        if (!$id) {
//            return $this->redirect()->toRoute('post', [
//                'action' => 'add'
//            ]);
//        }
//        try {
//            $post = $this->getEntityManager()->getRepository('Blog\Model\Blog')->find($id);
//        } catch (\Exception $ex) {
//            $this->redirect()->toRoute('post', [
//                'action' => 'index'
//            ]);
//        }
//        $form = $this->createForm();
//        $form->bind($post);
//        $form->get('submit')->setAttribute('value', 'Save');
//
//        $request = $this->getRequest();
//        if ($request->isPost()) {
//            $form->setData($request->getPost());
//
//            if ($form->isValid()) {
//                $this->getEntityManager()->flush();
//                return $this->redirect()->toRoute('post');
//            }
//        }
//        return ['form'=>$form];
//    }
//
//    public function deleteAction()
//    {
//        $id = (int)$this->params()->fromRoute('id', 0);
//        if (!$id) {
//            return $this->redirect()->toRoute('post');
//        }
//        $request = $this->getRequest();
//        $post = $this->getEntityManager()->getRepository('Blog\Model\Blog')->find($id);
//        if ($request->isPost()) {
//            $del = $request->getPost('del', 'No');
//            if ($del == 'Yes') {
//                $this->getEntityManager()->remove($post);
//                $this->getEntityManager()->flush();
//            }
//            return $this->redirect()->toRoute('post');
//        }
//        return ['post'=>$post];
//    }

    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}

