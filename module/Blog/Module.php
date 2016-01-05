<?php
namespace Blog;

use Blog\Form\PostForm;
use Blog\Model\Post;
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
                }
            ]
        ];
    }

}
