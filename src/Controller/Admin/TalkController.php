<?php

namespace ConferenceTools\Speakers\Controller\Admin;

use ConferenceTools\Speakers\Controller\AppController;
use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Command\AddAdditionalTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\CancelTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateTalk;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

class TalkController extends AppController
{
    public function cancelAction()
    {
        //@TODO add a check that this isn't their last talk? (or rely on UI?)
        //@TODO add an are you sure form
        $speakerId = $this->params()->fromRoute('speakerId');
        $talkId = (int) $this->params()->fromRoute('talkId');

        $this->messageBus()->fire(new CancelTalk($speakerId, $talkId));

        return $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speakerId]);
    }

    public function addAction()
    {
        //probably restrict this to admins

        $form = new Form();

        $speakerId = $this->params()->fromRoute('speakerId');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new AddAdditionalTalk($speakerId, new Talk($data['title'], $data['abstract']));
                $this->messageBus()->fire($command);

                //redirect base on role
                //add flash message
                return;
            }
        }

        return new ViewModel(['form' => $form]);
    }

    public function editAction()
    {
        $speakerId = $this->params()->fromRoute('speakerId');
        $talkId = $this->params()->fromRoute('talkId');
        /** @var Speaker $speaker */
        $speaker = $this->repository(Speaker::class)->get($speakerId);
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

        $speakerId = $this->params()->fromRoute('speakerId');
        $talkId = (int) $this->params()->fromRoute('talkId');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new UpdateTalk($speakerId, $talkId, new Talk($data['title'], $data['abstract']));
                $this->messageBus()->fire($command);

                $this->flashMessenger()->addSuccessMessage('Talk updated');
                $this->redirect()->toRoute('speakers/speaker', ['speakerId' => $speaker->getIdentity()]);
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Edit Talk']);
        $viewModel->setTemplate('admin/form');
        return $viewModel;
    }
}
