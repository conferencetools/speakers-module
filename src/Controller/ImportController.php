<?php

namespace ConferenceTools\Speakers\Controller;

use ConferenceTools\Speakers\Domain\Speaker\Bio;
use ConferenceTools\Speakers\Domain\Speaker\Command\InviteToSpeak;
use ConferenceTools\Speakers\Domain\Speaker\Email;
use ConferenceTools\Speakers\Domain\Speaker\Talk;

class ImportController extends AppController
{
    public function indexAction()
    {
        //@TODO form stuff
        //@TODO parse csv/json into data array

        $uploadedFileData = [];

        foreach ($uploadedFileData AS $speaker) {
            //@TODO fire command to create user account

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