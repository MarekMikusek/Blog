<?php
/**
 * Created by PhpStorm.
 * User: Marek
 * Date: 2015-12-22
 * Time: 10:45
 */

namespace Album\Form;


use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class AlbumForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('album');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
            ],
        ]);
        $this->add([
            'name' => 'artist',
            'type' => 'Text',
            'options' => [
                'label' => 'Artist',
            ],
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
            'name' => 'artist',
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
                    ],
                ],
            ],
        ]);

        $this->setInputFilter($inputFilter);
    }
}