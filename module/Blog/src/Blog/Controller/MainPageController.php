<?php

namespace Blog\Controller;

use Blog\Form\PostForm;
use Blog\Model\Post;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as CollectionAdapter;
use Zend\Paginator\Paginator;

class MainPageController extends AbstractActionController
{

    public function indexAction()
    {
        $posts = $this->getEntityManager()->getRepository('Blog\Model\Post')->findAll();
        $doctrineCollection = new ArrayCollection($posts);

        $adapter = new CollectionAdapter($doctrineCollection);

        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber(1)
            ->setItemCountPerPage(5);
        $paginator->setDefaultScrollingStyle('Sliding');
        $hasAuthentication = $this->zfcUserAuthentication()->hasIdentity();
        $hasAuthentication? $user_id = $this->zfcUserAuthentication()->getIdentity()->getId() : $user_id=0;
        $viewModel = new ViewModel();
        $viewModel->setVariable('posts', $paginator->getCurrentItems());
        $viewModel->setVariable('paginator', $paginator);
        $viewModel->setVariable('hasAuthentication', $hasAuthentication);
        $viewModel->setVariable('user_id', $user_id);
        return $viewModel;
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

