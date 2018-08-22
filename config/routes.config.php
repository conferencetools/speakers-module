<?php

use ConferenceTools\Speakers\Controller;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Placeholder;
use Zend\Router\Http\Segment;

return [
    'speakers' => [
        'type' => Placeholder::class,
        'child_routes' => [
            'redirect' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => '', //@TODO
                        'action'=> 'redirectToProperPlace'
                    ]
                ]
            ],
            'import' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/import',
                    'defaults' => [
                        'controller' => Controller\ImportController::class,
                        'action' => 'index',
                    ],
                ]
            ],
            'invitation' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/invitation/:speakerId',
                    'defaults' => [
                        'controller' => Controller\InvitationController::class,
                        'action' => 'index',
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'accept' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/accept',
                            'defaults' => [
                                'action' => 'accept-invitation'
                            ],
                        ],
                    ],
                    'decline' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/accept',
                            'defaults' => [
                                'action' => 'accept-invitation'
                            ],
                        ],
                    ],
                ],
            ],
            'talk' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/talk/:speakerid',
                    'defaults' => [
                        'controller' => \ConferenceTools\Speakers\Controller\TalkController::class,
                    ],
                ],
                'child_routes' => [
                    'cancel' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:talkId/cancel',
                            'defaults' => [
                                'action' => 'cancel'
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/:talkId/edit',
                            'defaults' => [
                                'action' => 'edit'
                            ],
                        ],
                    ],
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'action' => 'add'
                            ],
                        ],
                    ],
                ]
            ],
            'dashboard' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/dashboard',
                    'defaults' => [
                        'controller' => '', //@TODO
                        'action' => 'index',
                    ]
                ]
            ]
        ]
    ]
];
