<?php


namespace ConferenceTools\Speakers\Domain\Actor;


use Phactor\Test\ActorHelper;
use ConferenceTools\Speakers\Domain\Speaker\Command\AcceptInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Command\InviteToSpeak;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerAcceptedInvitation;
use ConferenceTools\Speakers\Domain\Speaker\Talk;
use ConferenceTools\Speakers\Domain\Speaker\Event\SpeakerWasInvited;
use ConferenceTools\Speakers\Domain\Speaker\Speaker;
use ConferenceTools\Speakers\Domain\Speaker\Email;

class SpeakerTest
{
    /**
     * @var ActorHelper
     */
    private $helper;

    public function setUp()
    {
        $this->helper = new ActorHelper(Speaker::class);
    }

    public function test_speaker_invitation()
    {
        $identity = $this->helper->getActorIdentity()->getId();
        $talk = new Talk('How to blog', 'Blogging is cool');
        $email = new Email('joe@blogs.com');
        $bio = 'Very cool speaker';
        $name = 'Joe Blogs';

        $this->helper
             ->when(new InviteToSpeak($name, $bio, $email, $talk))
             ->expect([new SpeakerWasInvited($identity, $name, $bio, $email, $talk)]);
    }

    public function test_speaker_accept_invitation()
    {
        $identity = $this->helper->getActorIdentity()->getId();
        $talk = new Talk('How to blog', 'Blogging is cool');
        $email = new Email('joe@blogs.com');
        $bio = 'Very cool speaker';
        $name = 'Joe Blogs';

        $this->helper
             ->given([new SpeakerWasInvited($identity, $name, $bio, $email, $talk)])
             ->when(new AcceptInvitation($identity))
             ->expect([new SpeakerAcceptedInvitation($identity)]);
    }
}