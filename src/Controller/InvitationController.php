<?php


namespace ConferenceTools\Speakers\Controller;


use ConferenceTools\Speakers\Domain\Dashboard\Entity\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Command\DeclineInvitation;
use Zend\View\Model\ViewModel;

class InvitationController extends AppController
{
    public function indexAction()
    {
        /** @var Speaker $speaker */
        $speaker = $this->currentSpeaker();

        if ($speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/dashboard');
        }

        return new ViewModel(['speaker' => $speaker]);
    }

    public function acceptInvitationAction()
    {
        /** @var Speaker $speaker */
        $speaker = $this->currentSpeaker();

        if ($speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/dashboard');
        }

        $command = new AcceptInvitation($speaker->getIdentity());
        $this->messageBus()->fire($command);

        return $this->redirect()->toRoute('speakers/dashboard');
    }

    public function declineInvitationAction()
    {
        /** @var Speaker $speaker */
        $speaker = $this->currentSpeaker();

        if ($speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/dashboard');
        }

        $command = new DeclineInvitation($speaker->getIdentity());
        $this->messageBus()->fire($command);

        return new ViewModel();
    }
}