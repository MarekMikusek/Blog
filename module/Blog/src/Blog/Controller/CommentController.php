<?php

namespace Blog\Controller;

use Blog\Model\Comment;
use Zend\View\Model\ViewModel;

class CommentController extends AbstractBlogController
{

    public function indexAction()
    {
        return new ViewModel([
            'comments' => $this->getEntityManager()->getRepository('Blog\Model\Comment')->findAll()
        ]);
    }

    public function addAction()
    {
        $form = $this->createForm('Blog\Form\Comment');
        $form->get('submit')->setValue('Add');

        $postId = (int)$this->params()->fromRoute('id', 0);
        $post = $this->getEntityManager()->getRepository('Blog\Model\Post')->find($postId);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                /** @var Comment $comment */
                $comment = $form->getData();
                $comment->setUser($this->zfcUserAuthentication()->getIdentity());
                $comment->setPost($post);
                $blogService = $this->getServiceLocator()->get('BlogService');
                $blogService->insertData($comment);
                return $this->redirect()->toRoute('post', ['action' => 'show', 'id' => $postId]);
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('comment', [
                'action' => 'add',
            ]);
        }
        try {
            $comment = $this->getEntityManager()->getRepository('Blog\Model\Comment')->find($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('mainpage');
        }
        $form = $this->createForm();
        $form->bind($comment);
        $form->get('submit')->setAttribute('value', 'Save');


        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('mainpage');
            }
        }
        return [
            'form' => $form,
        ];
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        $request = $this->getRequest();
        $comment = $this->getEntityManager()->getRepository('Blog\Model\Comment')->find($id);
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $blogService = $this->getServiceLocator()->get('BlogService');
                $blogService->deleteData($comment);
//                $this->getEntityManager()->remove($comment);
//                $this->getEntityManager()->flush($comment);
            }
            return $this->redirect()->toRoute('post');
        }
        return [
            'comment' => $comment
        ];
    }

}