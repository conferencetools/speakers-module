<?php
return [
    'driver' => [
        'dashboard' => [
            'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
            'cache' => 'array',
            'paths' => [__DIR__ . '/../src/Domain/Dashboard/Entity']
        ],
        'orm_default' => [
            'drivers' => [
                'ConferenceTools\\Speakers\\Domain\\Dashboard\\Entity' => 'dashboard'
            ]
        ]
    ],
];
