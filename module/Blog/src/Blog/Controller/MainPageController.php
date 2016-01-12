<?php

namespace Blog\Controller;

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
        $isAuthenticated = $this->zfcUserAuthentication()->hasIdentity();
        $isAuthenticated ? $user_id = $this->zfcUserAuthentication()->getIdentity()->getId() : $user_id = 0;

        return [
            'posts' => $paginator->getCurrentItems(),
            'paginator' => $paginator,
            'isAuthenticated' => $isAuthenticated,
            'user_id' => $user_id,
        ];

    }

//    public function createForm()
//    {
//        $sl = $this->getServiceLocator();
//        $form = $sl->get('FormElementManager')->get('\Blog\Form\Blog');
//        return $form;
//    }
//
//    public function getEntityManager()
//    {
//        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
//    }
}

