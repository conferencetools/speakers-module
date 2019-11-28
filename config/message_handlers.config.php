<?php

return [
    'factories' => [
        \ConferenceTools\Speakers\Domain\Dashboard\SpeakerProjector::class => \ConferenceTools\Speakers\Factory\SpeakerProjectorFactory::class,
        \ConferenceTools\Speakers\Domain\File\FileProjector::class => \ConferenceTools\Speakers\Factory\FileProjectorFactory::class,
        \ConferenceTools\Speakers\Emails\EmailInvite::class => \ConferenceTools\Speakers\Emails\EmailInviteFactory::class,
    ]
];