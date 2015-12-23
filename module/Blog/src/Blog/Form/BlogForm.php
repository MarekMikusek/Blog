<?php

namespace Blog\Form;

use Zend\Form\Annotation\InputFilter;
use Zend\Form\Form;

class BlogForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('blog');

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
            'name' => 'category',
            'type' => 'text',
            'options' => [
                'label' => 'Category'
            ]
        ]);

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
            'filters' =>[
                ['name'=> 'StripTags'],
                ['name'=>'StringTrim'],
            ],
            'validators'=>[
                [
                    'name'=>'StringLength',
                    'options'=>[
                        'encoding'=>'UTF-8',
                        'min'=>1,
                        'max'=>100,
                    ]
                ]
            ]
        ]);
        $inputFilter->add([
            'name'=>'content',
            'required'=>true,
            'filters'=>[
                ['name'=>'StripTags'],
                ['name'=>'StringTrim']
            ],
            'validators'=>[
                [
                    'name'=>'StringLength',
                    'options'=>[
                        'encoding'=>'UTF-8',
                        'min'=>1,
                        'max'=>255,
                    ]
                ]
            ]
        ]);
    }
}

;
