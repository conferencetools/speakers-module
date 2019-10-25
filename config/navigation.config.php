<?php
return [
    'default' => [
        [
            'label' => 'Speakers',
            'uri' => '',
            'permission' => 'speaker-organiser',
            'pages' => [
                [
                    'label' => 'List',
                    'route' => 'speakers/speakers',
                ],
                [
                    'label' => 'Import',
                    'route' => 'speakers/import',
                ],
                [
                    'label' => 'Travel Reimbursements',
                    'route' => 'speakers/travel-reimbursements',
                ],
                [
                    'label' => 'Station Pickups',
                    'route' => 'speakers/station-pickups',
                ],
                [
                    'label' => 'Hotel Bookings',
                    'route' => 'speakers/hotel-bookings',
                ],
            ],
        ],
    ],
];