<?php

namespace ConferenceTools\Speakers\Form;

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
        $this->add(new Textarea('specialRequirements', ['label' => 'Special Requirements (dietary needs etc)']));
        $this->add(new Submit('submit', ['label' => 'Edit']));
    }
}