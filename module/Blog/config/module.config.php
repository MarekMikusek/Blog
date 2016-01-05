<?php
return array(

    'controllers' => [
        'invokables' => [
            'Blog\Controller\Post' => 'Blog\Controller\PostController',
            'Blog\Controller\Category' => 'Blog\Controller\CategoryController',
            'Blog\Controller\Comment' => 'Blog\Controller\CommentController',
            'Blog\Controller\MainPage' => 'Blog\Controller\MainPageController',
        ],
    ],
    'router' => [
        'routes' => [
            'post' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/post[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Blog\Controller\Post',
                        'action' => 'index',
                    ],
                ],
            ],
            'category' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/category[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Blog\Controller\Category',
                        'action' => 'index',
                    ],
                ],
            ],
            'comment' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/comment[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => 'Blog\Controller\Comment',
                        'action' => 'index',
                    ],
                ],
            ],
            'mainpage' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/mainpage/[page/:page]',
                    'constraints' => [
                        'page' => '[0-9]*',
                    ],
                    'defaults' => [
                        'controller' => 'Blog\Controller\MainPage',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'post' => __DIR__ . '/../view',
        ],
    ],

    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'my_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/Blog/Model',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'Blog\Model' => 'my_annotation_driver'
                )
            )
        )
    )
);