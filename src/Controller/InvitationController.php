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
        $speakerId = $this->params()->fromRoute('speakerId');
        /** @var Speaker $speaker */
        $speaker = $this->repository(Speaker::class)->get($speakerId);

        if ($speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/dashboard');
        }

        return new ViewModel(['speaker' => $speaker]);
    }

    public function acceptInvitationAction()
    {
        $speakerId = $this->params()->fromRoute('speakerId');
        /** @var Speaker $speaker */
        $speaker = $this->repository(Speaker::class)->get($speakerId);

        if ($speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/dashboard');
        }

        $command = new AcceptInvitation($speakerId);
        //@TODO catch errors and display
        $this->messageBus()->fire($command);

        return $this->redirect()->toRoute('speakers/dashboard');
    }

    public function declineInvitationAction()
    {
        //@TODO do we need a confirmation box?
        $speakerId = $this->params()->fromRoute('speakerId');
        /** @var Speaker $speaker */
        $speaker = $this->repository(Speaker::class)->get($speakerId);

        if ($speaker->hasResponded()) {
            return $this->redirect()->toRoute('speakers/dashboard');
        }

        $command = new DeclineInvitation($speakerId);
        //@TODO catch errors and display
        $this->messageBus()->fire($command);

        return new ViewModel();
    }
}