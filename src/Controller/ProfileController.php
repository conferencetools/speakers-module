<?php

namespace ConferenceTools\Speakers\Controller;

use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateProfile;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use ConferenceTools\Speakers\Form\ProfileForm;
use Zend\View\Model\ViewModel;

class ProfileController extends AppController
{
    public function editAction()
    {
        $speaker = $this->currentSpeaker();

        $data = [
            'name' => $speaker->getName(),
            'company' => $speaker->getCompany(),
            'twitter' => $speaker->getTwitter(),
            'aboutMe' => $speaker->getAboutMe(),
            'specialRequirements' => $speaker->getSpecialRequirements()
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
                    $data['specialRequirements']
                );
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Profile updated');
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Edit Profile']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }
}