<?php

use ConferenceTools\Speakers\Controller;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Placeholder;
use Zend\Router\Http\Segment;

return [
    'speakers' => [
        'type' => Placeholder::class,
        'options' => [
            'defaults' => [
                'layout' => 'speakers/layout',
                'requiresAuth' => true,
            ]
        ],
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
                        'controller' => Controller\Admin\ImportController::class,
                        'action' => 'index',
                    ],
                ]
            ],
            'invitation' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/invitation',
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
            'edit-profile' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/edit-profile',
                    'defaults' => [
                        'controller' => Controller\ProfileController::class,
                        'action' => 'edit'
                    ],
                ],
            ],
            'edit-talk' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/edit-talk/:talkId',
                    'defaults' => [
                        'controller' => Controller\TalkController::class,
                        'action' => 'edit'
                    ],
                ],
            ],
            'travel' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/travel',
                    'defaults' => [
                        'controller' => Controller\TravelController::class,
                    ],
                ],
                'child_routes' => [
                    'provide-details' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/provide-details',
                            'defaults' => [
                                'action' => 'provide-travel-details'
                            ],
                        ],
                    ],
                    'request-reimbursement' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/request-reimbursement',
                            'defaults' => [
                                'action' => 'request-reimbursement',
                            ],
                        ],
                    ],
                    'request-pickup' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/request-pickup',
                            'defaults' => [
                                'action' => 'request-station-pickup',
                            ],
                        ],
                    ],
                ],
            ],
            'hotel' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/hotel',
                    'defaults' => [
                        'action' => 'alter-booking',
                        'controller' => Controller\HotelController::class,
                    ],
                ],
            ],

            'dashboard' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/dashboard',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action' => 'index',
                    ]
                ]
            ],

            // Admin routes

            'speakers' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/speakers',
                    'defaults' => [
                        'action' => 'index',
                        'controller' => Controller\Admin\SpeakerController::class,
                        'requiresPermission' => 'speaker-organiser',
                        'layout' => 'admin/layout',
                    ],
                ],
            ],
            'speaker' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/speaker/:speakerId',
                    'defaults' => [
                        'action' => 'profile',
                        'controller' => Controller\Admin\SpeakerController::class,
                        'requiresPermission' => 'speaker-organiser',
                        'layout' => 'admin/layout',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'edit' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/edit',
                            'defaults' => [
                                'action' => 'edit',
                            ],
                        ],
                    ],
                    'talk' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/talk',
                            'defaults' => [
                                'controller' => Controller\Admin\TalkController::class,
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
                    'travel-reimbursement' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/travel-reimbursement',
                            'defaults' => [
                                'controller' => Controller\Admin\TravelReimbursementController::class,
                            ],
                        ],
                        'child_routes' => [
                            'reject' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/:reimbursementRequestId/reject',
                                    'defaults' => [
                                        'action' => 'reject'
                                    ],
                                ],
                            ],
                            'accept' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/:reimbursementRequestId/accept',
                                    'defaults' => [
                                        'action' => 'accept'
                                    ],
                                ],
                            ],
                            'paid' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/:reimbursementRequestId/paid',
                                    'defaults' => [
                                        'action' => 'paid'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'station-pickup' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/station-pickup',
                            'defaults' => [
                                'controller' => Controller\Admin\StationPickupController::class,
                            ],
                        ],
                        'child_routes' => [
                            'reject' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/:pickupRequestId/reject',
                                    'defaults' => [
                                        'action' => 'reject'
                                    ],
                                ],
                            ],
                            'accept' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/:pickupRequestId/accept',
                                    'defaults' => [
                                        'action' => 'accept'
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'hotel' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/hotel',
                            'defaults' => [
                                'action' => 'make-booking',
                                'controller' => Controller\Admin\HotelController::class,
                            ],
                        ],
                    ],
                ],
            ],
            'hotel-bookings' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/hotel-bookings',
                    'defaults' => [
                        'action' => 'index',
                        'controller' => Controller\Admin\HotelController::class,
                        'requiresPermission' => 'speaker-organiser',
                        'layout' => 'admin/layout',
                    ],
                ],
            ],
            'travel-reimbursements' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/travel-reimbursements',
                    'defaults' => [
                        'action' => 'index',
                        'controller' => Controller\Admin\TravelReimbursementController::class,
                        'requiresPermission' => 'speaker-organiser',
                        'layout' => 'admin/layout',
                    ],
                ],
            ],
            'station-pickups' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/station-pickups',
                    'defaults' => [
                        'action' => 'index',
                        'controller' => Controller\Admin\StationPickupController::class,
                        'requiresPermission' => 'speaker-organiser',
                        'layout' => 'admin/layout',
                    ],
                ],
            ],
        ]
    ]
];
