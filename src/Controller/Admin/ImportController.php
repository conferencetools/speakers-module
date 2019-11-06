<?php

namespace ConferenceTools\Speakers\Controller\Admin;

use ConferenceTools\Authentication\Domain\User\Command\ChangeUserPermissions;
use ConferenceTools\Authentication\Domain\User\Command\CreateNewUser;
use ConferenceTools\Authentication\Domain\User\HashedPassword;
use ConferenceTools\Speakers\Controller\AppController;
use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Command\AddAdditionalTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\InviteToSpeak;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerWasInvited;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use Zend\Form\Element\File;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;

class ImportController extends AppController
{
    public function indexAction()
    {
        //@TODO refactor form into something configurable and a separate class.
        //@TODO add form validation

        $form = new Form();
        $form->add(new File('upload', ['label' => 'Speakers json file']));
        $form->add([
            'type' => Submit::class,
            'options' => [
                'label' => 'Upload',
            ],
            'attributes' => [
                'class'=> 'btn-primary',
            ],
        ]);

        if ($this->getRequest()->isPost()) {
            $form->setData(\array_merge($this->params()->fromFiles(), $this->params()->fromPost()));
            if ($form->isValid()) {
                $data = $form->getData();
                $this->importFile($data['upload']);
                $this->redirect()->toRoute('speakers/speakers');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Import speakers']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }

    /**
     * @todo Needs to handle issues with parsing json
     * @TODO allow csv uploads as well
     */
    private function importFile($file): void
    {
        $fileData = \file_get_contents($file['tmp_name']);

        $speakerData = \json_decode($fileData, true);

        foreach ($speakerData AS $speaker) {

            if (isset($speaker['password'])) {
                $password = HashedPassword::fromHash($speaker['password']);
            } else {
                $password = new HashedPassword('Password1');
            }

            $command = new CreateNewUser(
                $speaker['email'],
               $password
            );

            $this->messageBus()->fire($command);

            $command = new ChangeUserPermissions($speaker['email'], ['speaker']);

            $this->messageBus()->fire($command);

            $messages = $this->messageBus()->fire(
                new InviteToSpeak(
                    $speaker['name'],
                    new Bio($speaker['profile'], $speaker['twitter'], $speaker['company']),
                    new Email($speaker['email'])
                )
            );

            $speakerId = $this->messageBus()->firstInstanceOf(SpeakerWasInvited::class, ...$messages)->getIdentity();

            if (isset($speaker['talks']) && is_array($speaker['talks'])) {
                foreach ($speaker['talks'] as $talk) {
                    $command = new AddAdditionalTalk($speakerId, new Talk($talk['title'], $talk['abstract']));
                    $this->messageBus()->fire($command);
                }
            }
        }
    }
}