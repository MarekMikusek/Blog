<?php
namespace Blog;

use Blog\Form\CommentForm;
use Blog\Model\Comment;
use Blog\Form\PostForm;
use Blog\Form\UserForm;
use Blog\Model\Category;
use Blog\Form\CategoryForm;
use Blog\Model\Post;
use Blog\Model\User;
use Blog\Service\BlogService;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class Module implements FormElementProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getFormElementConfig()
    {
        return [
            'factories' => [
                'Blog\Form\Post' => function ($sm) {
                    $sl = $sm->getServiceLocator();
                    $objectManager = $sl->get('Doctrine\ORM\EntityManager');

                    $form = new PostForm();
                    $form->setHydrator(new DoctrineHydrator($objectManager))
                        ->setObject(new Post());
                    return $form;
                },
                'Blog\Form\User' => function ($sm) {
                    $sl = $sm->getServiceLocator();
                    $objectManager = $sl->get('Doctrine\ORM\EntityManager');

                    $form = new UserForm();
                    $form->setHydrator(new DoctrineHydrator($objectManager))
                        ->setObject(new User());
                    return $form;
                },
                'Blog\Form\Comment' => function ($sm) {
                    $sl = $sm->getServiceLocator();
                    $objectManager = $sl->get('Doctrine\ORM\EntityManager');

                    $form = new CommentForm();
                    $form->setHydrator(new DoctrineHydrator($objectManager))
                        ->setObject(new Comment());
                    return $form;
                },
                'Blog\Form\Category' => function ($sm) {
                    $sl = $sm->getServiceLocator();
                    $objectManager = $sl->get('Doctrine\ORM\EntityManager');

                    $form = new CategoryForm();
                    $form->setHydrator(new DoctrineHydrator($objectManager))
                        ->setObject(new Category());
                    return $form;
                },
            ]
        ];
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function ($serviceManager) {
                    // If you are using DoctrineORMModule:
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },

            ),
            'invokables' => [
                'BlogService'=>'Blog\Service\BlogService'
            ]
        );
    }
}
