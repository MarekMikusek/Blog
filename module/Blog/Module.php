<?php
namespace Blog;

use Blog\Form\PostForm;
use Blog\Form\UserForm;
use Blog\Model\Post;
use Blog\Model\User;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

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

                    $form = new PostForm();
                    $form->setHydrator(new DoctrineHydrator($objectManager))
                        ->setObject(new Post());
                    return $form;
                },
                'Blog\Form\Category' => function ($sm) {
                    $sl = $sm->getServiceLocator();
                    $objectManager = $sl->get('Doctrine\ORM\EntityManager');

                    $form = new PostForm();
                    $form->setHydrator(new DoctrineHydrator($objectManager))
                        ->setObject(new Post());
                    return $form;
                }
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
                }
            )
        );
    }
}
