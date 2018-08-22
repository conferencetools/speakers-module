<?php

namespace ConferenceTools\Speakers\Controller;

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
        $form->add(new File('upload'));
        $form->add(new Submit('submit'));

        if ($this->getRequest()->isPost()) {
            $form->setData(\array_merge($this->params()->fromFiles(), $this->params()->fromPost()));
            if ($form->isValid()) {
                $data = $form->getData();
                $this->importFile($data['upload']);
            }
        }

        return new ViewModel(['form' => $form]);
    }

    /**
     * @todo Needs to handle issues with parsing json
     * @TODO refactor into service class
     * @TODO allow csv uploads as well
     */
    private function importFile($file): void
    {
        $fileData = \file_get_contents($file['tmp_name']);

        $speakerData = \json_decode($fileData, true);

        foreach ($speakerData AS $speaker) {
            //@TODO fire command to create user account

            $talks = [];
            foreach ($speaker['talks'] as $talk) {
                $talks[] = new Talk($talk['title'], $talk['abstract']);
            }
            $events = $this->messageBus()->fire(
                new InviteToSpeak(
                    $speaker['name'],
                    new Bio($speaker['profile'], $speaker['twitter'], $speaker['company']),
                    new Email($speaker['email']),
                    ...$talks
                )
            );
echo '<pre>';
            \var_dump($events);
            echo '</pre>';
        }
    }
}