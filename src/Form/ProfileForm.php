<?php

namespace ConferenceTools\Speakers\Form;

use ConferenceTools\Speakers\Domain\Speaker\DietaryRequirements;
use Zend\Form\Element\Radio;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class ProfileForm extends Form
{
    public function init()
    {
        $this->add(new Text('name', ['label' => 'Name']));
        $this->add(new Text('company', ['label' => 'Company Name']));
        $this->add(new Text('twitter', ['label' => 'Twitter']));
        $this->add(new Textarea('aboutMe', ['label' => 'About You']));
        $this->add([
            'type' => Radio::class,
            'name' => 'preference',
            'options' => [
                'value_options' => [
                    DietaryRequirements::NONE => 'None',
                    DietaryRequirements::VEGETARIAN => 'Vegetarian',
                    DietaryRequirements::VEGAN => 'Vegan',
                ],
                'label' => 'Dietary Preference',
                'help-block' => 'We\'ll pass this on to the caterers'

            ],
        ]);
        $this->add([
            'type' => Text::class,
            'name' => 'allergies',
            'options' => [
                'label' => 'Any Allergies',
                'help-block' => 'We\'ll pass this on to the caterers, please also make yourself known to them on the day'
            ],
        ]);
        $this->add(new Textarea('specialRequirements', ['label' => 'Accessibility requirements']));
        $this->add(new Submit('submit', ['label' => 'Edit']));
    }
}