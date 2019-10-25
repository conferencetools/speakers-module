<?php

namespace ConferenceTools\Speakers\Form;

use Zend\Form\Element\Checkbox;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class HotelBookingForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => MultiCheckbox::class,
            'name'=> 'dates',
            'options' => [
                'label' => 'Nights to book',
                'value_options' => $this->getOption('available_dates')
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