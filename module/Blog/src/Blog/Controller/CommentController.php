<?php

namespace Blog\Controller;

use Blog\Form\CommentForm;
use Blog\Model\Comment;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;

class CommentController extends AbstractActionController
{

    public function createForm()
    {
        $form = new CommentForm();
        $form->setHydrator(new ClassMethods())
            ->setObject(new Comment());
        return $form;
    }

    public function indexAction()
    {
        return new ViewModel([
            'comments' => $this->getEntityManager()->getRepository('Blog\Model\Comment')->findAll()
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
                return $this->redirect()->toRoute('blog');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', [
                'action' => 'add',
            ]);
        }
        try {
            $album = $this->getEntityManager()->getRepository('Blog\Model\Comment')->find($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('blog', [
                'action' => 'index'
            ]);
        }
        $form = $this->createForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Save');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEntityManager()->flush();
                return $this->redirect()->toRoute('album');
            }
        }
        return [
            'id' => $id,
            'form' => $form,
        ];
    }

    public function deleteAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('blog');
        }

        $request = $this->getRequest();
        $comment = $this->getEntityManager()->getRepository('Blog\Model\Comment')->find($id);
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                //  $id = (int)$request->getPost('id');
                $this->getEntityManager()->remove($comment);
                $this->getEntityManager()->flush($comment);
            }
            return $this->redirect()->toRoute('blog');
        }
        return [
            'comment' => $comment
        ];
    }

//    /**
//     * @return \Blog\Model\CommentTable
//     */
//    public function getCommentTable()
//    {
//        if (!$this->albumTable) {
//            $sm = $this->getServiceLocator();
//            $this->commentTable = $sm->get('Blog\Model\CommentTable');
//        }
//        return $this->commentTable;
//    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}