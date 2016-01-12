<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2015-12-23
 * Time: 12:34
 */

namespace Blog\Controller;

use Zend\View\Model\ViewModel;


class CategoryController extends AbstractBlogController
{

    public function indexAction()
    {
        return new ViewModel([
            'categories' => $this->getEntityManager()->getRepository('Blog\Model\Category')->findAll()
        ]);
    }

    public function addAction()
    {
        $form = $this->createForm('Blog\Model\Category');
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
        $form = $this->createForm('Blog\Model\Category');
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
        return ['category' => $category];
    }

}