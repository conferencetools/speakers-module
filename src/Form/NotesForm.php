<?php

namespace ConferenceTools\Speakers\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class NotesForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => Textarea::class,
            'name'=> 'notes',
            'options' => [
                'label' => $this->getOption('field-label'),
            ]
        ]);

        $this->add([
            'type' => Submit::class,
            'options' => [
                'label' => 'Submit',
            ],
            'attributes' => [
                'class'=> 'btn-primary',
            ],
        ]);
    }
}