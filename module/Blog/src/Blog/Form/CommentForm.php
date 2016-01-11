<?php

namespace Blog\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CommentForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('comment');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'content',
            'type' => 'Text',
            'options' => [
                'label' => 'Content',
            ],
        ]);

        $this->add([
            'name'=>'post',
            'type'=>'hidden'
        ]);

        $this->add([
            'name' => 'creationDate',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'user_id',
            'type' => 'hidden',
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
            'name' => 'content',
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
                    ],
                ],
            ],
        ]);

        $this->setInputFilter($inputFilter);
    }
}