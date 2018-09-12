<?php

namespace ConferenceTools\Speakers\Controller;

use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateProfile;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;

class ProfileController extends AppController
{
    public function editAction()
    {
        $speakerId = $this->params()->fromRoute('speakerId');
        /** @var Speaker $speaker */
        $speaker = $this->repository(Speaker::class)->get($speakerId);

        $data = [
            'name' => $speaker->getName(),
            'email' => $speaker->getEmail(),
            'company' => $speaker->getCompany(),
            'twitter' => $speaker->getTwitter(),
            'aboutMe' => $speaker->getAboutMe(),
            'specialRequirements' => $speaker->getSpecialRequirements()
        ];

        $form = new Form();
        $form->add(new Text('name', ['label' => 'Name']));
        $form->add(new Text('email', ['label' => 'Email']));
        $form->add(new Text('company', ['label' => 'Company Name']));
        $form->add(new Text('twitter', ['label' => 'Twitter']));
        $form->add(new Textarea('aboutMe', ['label' => 'About You']));
        $form->add(new Textarea('specialRequirements', ['label' => 'Special Requirements (dietary needs etc)']));
        $form->add(new Submit('submit', ['value' => 'Edit']));
        $form->setData($data);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new UpdateProfile(
                    $speakerId,
                    $data['name'],
                    new Email($data['email']),
                    new Bio($data['aboutMe'], $data['twitter'], $data['company']),
                    $data['specialRequirements']
                );
                $this->messageBus()->fire($command);

                //redirect base on role
                //add flash message
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        return new ViewModel(['form' => $form]);
    }
}