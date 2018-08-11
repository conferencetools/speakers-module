<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Speaker\Command\AddAdditionalTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\CancelTalk;
use ConferenceTools\Speakers\Domain\Speaker\Command\UpdateTalk;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use Zend\View\Model\ViewModel;

class TalkController extends AppController
{
    public function cancelAction()
    {
        //probably restrict this to admins

        //@TODO add a check that this isn't their last talk? (or rely on UI?)
        //@TODO add an are you sure form
        $speakerId = $this->params()->fromRoute('speakerId');
        $talkId = (int) $this->params()->fromRoute('talkId');

        $this->messageBus()->fire(new CancelTalk($speakerId, $talkId));

        //@TODO add redirect + flash message
    }

    public function addAction()
    {
        //probably restrict this to admins

        //@TODO bring in Zend form
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
        //probably restrict this to admins

        //@TODO bring in Zend form
        $form = new Form();

        $speakerId = $this->params()->fromRoute('speakerId');
        $talkId = (int) $this->params()->fromRoute('talkId');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();
                $command = new UpdateTalk($speakerId, $talkId, new Talk($data['title'], $data['abstract']));
                $this->messageBus()->fire($command);

                //redirect base on role
                //add flash message
                return;
            }
        }

        return new ViewModel(['form' => $form]);
    }
}
