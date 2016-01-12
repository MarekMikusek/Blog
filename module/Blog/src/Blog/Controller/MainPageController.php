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

class MainPageController extends AbstractBlogController
{

    public function indexAction()
    {
        $page = $this->params()->fromRoute('page', 1);

        $posts = $this->getEntityManager()->getRepository('Blog\Model\Post')->findAll();
        $doctrineCollection = new ArrayCollection($posts);

        $adapter = new CollectionAdapter($doctrineCollection);

        $paginator = new Paginator($adapter);
        $paginator->setCurrentPageNumber($page)
            ->setItemCountPerPage(5);
        $paginator->setDefaultScrollingStyle('Sliding');
        $hasAuthentication = $this->zfcUserAuthentication()->hasIdentity();
        $hasAuthentication ? $user_id = $this->zfcUserAuthentication()->getIdentity()->getId() : $user_id = 0;

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
    }

    public function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}

