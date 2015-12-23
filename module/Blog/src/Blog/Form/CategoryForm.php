<?php

namespace Category\Form;

use Zend\InputFilter\InputFilter;

class CategoryForm extends \Zend\Form\Form
{

    public function __construct($name = null)
    {
        parent::__construct('category');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'categoryName',
            'type' => 'text',
            'options' => [
                'label' => 'CategoryName'
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
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton',
            ],
        ]);
        $inputFilter = new InputFilter();
        $inputFilter->add([
            'name' => 'category',
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
        $this->setInputFilter($inputFilter);
    }
}

;