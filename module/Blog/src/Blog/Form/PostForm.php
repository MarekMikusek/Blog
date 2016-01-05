<?php

namespace Blog\Form;

use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PostForm extends Form implements ObjectManagerAwareInterface
{
    protected $objectManager;

    public function __construct($name = null)
    {
        parent::__construct('post');
    }

    public function init()
    {
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title'
            ]
        ]);

        $this->add([
            'name' => 'content',
            'type' => 'text',
            'options' => [
                'label' => 'Content'
            ]
        ]);
        $this->add([
            'name'=>'creationDate',
            'type'=>'hidden'
        ]);

        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'category',
                'options' => array(
                    'label' => 'Category',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Blog\Model\Category',
                    'property' => 'categoryName',
                ),
            )
        );

        $this->add([
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton',
            ],
        ]);

        $inputFilter = new InputFilter();
        $inputFilter->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ]
                ]
            ]
        ]);
        $inputFilter->add([
            'name' => 'content',
            'required' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim']
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 255,
                    ]
                ]
            ]
        ]);
    }

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }


}

;
