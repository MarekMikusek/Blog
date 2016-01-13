<?php

namespace Blog\Controller;

use Blog\Form\PostForm;
use Blog\Model\Post;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class PostController extends AbstractBlogController
{

    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->getEntityManager()->getRepository('Blog\Model\Post')->findAll()
        ]);
    }

    public function showAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('mainpage');
        }

        try {
            $post = $this->getEntityManager()->getRepository('Blog\Model\Post')->find($id);
            $comments = $this->getEntityManager()->getRepository('Blog\Model\Comment')->findBy(['post' => $id]);
        } catch (\Exception $ex) {
            $this->redirect()->toRoute('mainpage', [
                'action' => 'index'
            ]);
        }
        return [
            'post' => $post,
            'comments' => $comments,
            'hasAuthentication' => $this->zfcUserAuthentication()->hasIdentity(),
            'user_id' => $this->zfcUserAuthentication()->getIdentity()->getId(),
        ];
    }

    public function addAction()
    {
        $form = $this->createForm('Blog\Form\Post');
        $form->get('submit')->setValue('add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $post = $form->getData();
                $post->setUser($this->zfcUserAuthentication()->getIdentity());
                $blogService = $this->getServiceLocator()->get('BlogService');
                $blogService->insertData($post);
                $this->flashMessenger()->addMessage('Post added!');
                return $this->redirect()->toRoute('mainpage');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post', [
                'action' => 'add'
            ]);
        }
        try {
            $post = $this->getEntityManager()->getRepository('Blog\Model\Post')->find($id);
        } catch (\Exception $ex) {

            $this->redirect()->toRoute('mainpage');
        }
        $form = $this->createForm('Blog\Form\Post');
        $form->bind($post);
        $form->get('submit')->setAttribute('value', 'Save');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('post');
            }
        }
        return [
            'id' => $id,
            'form' => $form];
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }
        $request = $this->getRequest();
        $post = $this->getEntityManager()->getRepository('Blog\Model\Post')->find($id);
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $comments = $this->getEntityManager()->getRepository('Blog\Model\Comment')->findBy(['post' => $id]);
                $blogService = $this->getServiceLocator()->get('BlogService');
                foreach ($comments as $comment) {
                    $blogService->deleteData($comment);
                }
                $blogService->deleteData($post);
                $this->flashMessenger()->addMessage('Post deleted!');
            }
            return $this->redirect()->toRoute('mainpage');
        }
        return ['post' => $post];
    }

}

