<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Command\DeclineInvitation;
use Zend\View\Model\ViewModel;

class InvitationController extends AppController
{
    public function indexAction()
    {
        //@TODO retrieve speaker information (Eg talks selected)

        return new ViewModel();
    }

    public function acceptInvitationAction()
    {
        $speakerId = $this->params()->fromRoute('speakerId');
        $command = new AcceptInvitation($speakerId);
        //@TODO catch errors and display
        $this->messageBus()->fire($command);

        return $this->redirect()->toRoute('speakers/dashboard');
    }

    public function declineInvitationAction()
    {
        $speakerId = $this->params()->fromRoute('speakerId');
        $command = new DeclineInvitation($speakerId);
        //@TODO catch errors and display
        $this->messageBus()->fire($command);

        return new ViewModel();
    }
}