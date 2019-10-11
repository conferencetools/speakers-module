<?php

namespace ConferenceTools\Speakers\Controller;

use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateTalk;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

class TalkController extends AppController
{
    public function editAction()
    {
        $talkId = $this->params()->fromRoute('talkId');
        /** @var Speaker $speaker */
        $speaker = $this->currentSpeaker();
        $talk = $speaker->getTalk($talkId);

        $data = [
            'title' => $talk->getTitle(),
            'abstract' => $talk->getAbstract()
        ];

        $form = new Form();
        $form->add(new Text('title', ['label' => 'Title']));
        $form->add(new Textarea('abstract', ['label' => 'Abstract']));
        $form->add(new Submit('submit', ['label' => 'Edit']));
        $form->setData($data);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new UpdateTalk($speaker->getIdentity(), $talkId, new Talk($data['title'], $data['abstract']));
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Talk updated, one of the conference staff will update the website shortly');
                $this->redirect()->toRoute('speakers/dashboard');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Edit Talk']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }
}
