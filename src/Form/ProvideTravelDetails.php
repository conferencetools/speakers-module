<?php


namespace ConferenceTools\Speakers\Form;


use Zend\Form\Element\DateTime;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class ProvideTravelDetails extends Form
{
    public function init()
    {


        $this->add(new Text('departFrom', ['label' => 'Depart from']));
        $this->add([
            'type' => DateTime::class,
            'name' => 'departureTime',
            'options' => [
                'label' => 'Departure time',
            ],
            'attributes' => [
                'class'=> 'datetimepicker-input',
                'id' => "departureTime",
                'data-toggle' => "datetimepicker",
                'data-target' => "#departureTime",
                'autocomplete' => 'off',
            ],
        ]);
        $this->add(new Text('arriveAt', ['label' => 'Arrive at']));
        $this->add([
            'type' => DateTime::class,
            'name' => 'arrivalTime',
            'options' => [
                'label' => 'Arrival time',
            ],
            'attributes' => [
                'class'=> 'datetimepicker-input',
                'id' => "arrivalTime",
                'data-toggle' => "datetimepicker",
                'data-target' => "#arrivalTime",
                'autocomplete' => 'off',
            ],
        ]);
        $this->add(new Textarea('notes', ['label' => 'Notes']));
        $this->add(new Submit('submit', ['label' => 'Save']));
    }
}