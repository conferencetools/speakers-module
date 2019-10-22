<?php

namespace ConferenceTools\Speakers\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class RequestTravelReimbursementForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => Text::class,
            'name'=> 'amount',
            'options' => [
                'label' => 'Amount',
                'help-block' => 'Please enter the cost of travel in £ eg 147.19'
            ]
        ]);

        $this->add([
            'type' => Textarea::class,
            'name'=> 'notes',
            'options' => [
                'label' => 'Notes',
                'help-block' => 'Any additional details we need to be aware of. Please do not enter payment details in this field.'
            ]
        ]);

        $this->add([
            'type' => Submit::class,
            'options' => [
                'label' => 'Request',
            ],
            'attributes' => [
                'class'=> 'btn-primary',
            ],
        ]);
    }
}