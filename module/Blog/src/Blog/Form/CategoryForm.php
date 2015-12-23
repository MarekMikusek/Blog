<?php

namespace Blog\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CategoryForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('category');

        $this->add([
            'name' => 'categoryName',
            'type' => 'text',
            'options' => [
                'label' => 'Category name'
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
            'name' => 'categoryName',
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