<?php

namespace ConferenceTools\Speakers\Controller\Admin;

use ConferenceTools\Speakers\Controller\AppController;
use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateProfile;
use ConferenceTools\Speakers\Domain\Speaker\DietaryRequirements;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use ConferenceTools\Speakers\Form\ProfileForm;
use Doctrine\Common\Collections\Criteria;
use Zend\View\Model\ViewModel;

class SpeakerController extends AppController
{
    public function indexAction()
    {
        $speakers = $this->repository(Speaker::class)->matching(Criteria::create());
        return new ViewModel(['speakers' => $speakers]);
    }

    public function profileAction()
    {
        $speaker = $this->fetchSpeaker();
        $availableDates = [
            '2020-04-02' => 'Thursday 2nd of April',
            '2020-04-03' => 'Friday 3rd of April',
            '2020-04-04' => 'Saturday 4th April'
        ];
        return new ViewModel(['speaker' => $speaker, 'hotelDates' => $availableDates]);
    }

    public function editAction()
    {
        $speaker = $this->fetchSpeaker();

        $data = [
            'name' => $speaker->getName(),
            'company' => $speaker->getCompany(),
            'twitter' => $speaker->getTwitter(),
            'aboutMe' => $speaker->getAboutMe(),
            'specialRequirements' => $speaker->getSpecialRequirements(),
            'preference' => $speaker->getPreference(),
            'allergies' => $speaker->getAllergies(),
        ];

        $form = $this->form(ProfileForm::class);
        $form->setData($data);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new UpdateProfile(
                    $speaker->getIdentity(),
                    $data['name'],
                    new Email($speaker->getEmail()),
                    new Bio($data['aboutMe'], $data['twitter'], $data['company']),
                    $data['specialRequirements'],
                    new DietaryRequirements($data['preference'], $data['allergies'])
                );
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Profile updated');
                $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speaker->getIdentity()]);
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Edit Profile']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }

    private function fetchSpeaker(): Speaker
    {
        $speakerId = $this->params()->fromRoute('speakerId');
        $speaker = $this->repository(Speaker::class)->get($speakerId);
        return $speaker;
    }
}