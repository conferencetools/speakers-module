<?php

namespace ConferenceTools\Speakers\Form;

use Zend\Form\Element\DateTime;
use Zend\Form\Element\Radio;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class RequestStationPickupForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => Radio::class,
            'name'=> 'station',
            'options' => [
                'label' => 'Location',
                'value_options' => [
                    'York Station' => 'York Station',
                    'Leeds Bradford Airport' => 'Leeds Bradford Airport',
                ],
            ]
        ]);

        $this->add([
            'type' => DateTime::class,
            'name' => 'pickupTime',
            'options' => [
                'label' => 'Pickup time',
            ],
            'attributes' => [
                'class'=> 'datetimepicker-input',
                'id' => "departureTime",
                'data-toggle' => "datetimepicker",
                'data-target' => "#departureTime",
                'autocomplete' => 'off',
            ],
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