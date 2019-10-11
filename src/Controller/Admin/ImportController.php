<?php

namespace ConferenceTools\Speakers\Controller\Admin;

use ConferenceTools\Authentication\Domain\User\Command\ChangeUserPermissions;
use ConferenceTools\Authentication\Domain\User\Command\CreateNewUser;
use ConferenceTools\Authentication\Domain\User\HashedPassword;
use ConferenceTools\Speakers\Controller\AppController;
use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Command\InviteToSpeak;
use ConferenceTools\Speakers\Domain\Speaker\Email;
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
        $form->add(new Submit('submit', ['label' => 'Upload']));

        if ($this->getRequest()->isPost()) {
            $form->setData(\array_merge($this->params()->fromFiles(), $this->params()->fromPost()));
            if ($form->isValid()) {
                $data = $form->getData();
                $this->importFile($data['upload']);
            }
        }

        $viewModel = new ViewModel(['form' => $form]);
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

            $command = new CreateNewUser(
                $speaker['email'],
                new HashedPassword('Password1') //@TODO generate randomly and email to speaker later
            );

            $this->messageBus()->fire($command);

            $command = new ChangeUserPermissions($speaker['email'], ['speaker']);

            $this->messageBus()->fire($command);

            $talks = [];
            foreach ($speaker['talks'] as $talk) {
                $talks[] = new Talk($talk['title'], $talk['abstract']);
            }

            $this->messageBus()->fire(
                new InviteToSpeak(
                    $speaker['name'],
                    new Bio($speaker['profile'], $speaker['twitter'], $speaker['company']),
                    new Email($speaker['email']),
                    ...$talks
                )
            );
        }
    }
}