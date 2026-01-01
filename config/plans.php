<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Plan Definitions
    |--------------------------------------------------------------------------
    |
    | Define the limits and features for each plan. Set limit to null for
    | unlimited access. Features are boolean - true means the feature is
    | available on that plan.
    |
    */

    'free' => [
        'name' => 'Starter',
        'limits' => [
            'projects' => 3,
            'clients' => 5,
            'team_members' => 2,
        ],
        'features' => [
            'client_portal' => false,
            'custom_branding' => false,
            'advanced_reports' => false,
            'file_attachments' => false,
        ],
    ],

    'pro' => [
        'name' => 'Pro',
        'limits' => [
            'projects' => null, // unlimited
            'clients' => null,
            'team_members' => null,
        ],
        'features' => [
            'client_portal' => true,
            'custom_branding' => true,
            'advanced_reports' => true,
            'file_attachments' => true,
        ],
    ],

    'enterprise' => [
        'name' => 'Enterprise',
        'limits' => [
            'projects' => null,
            'clients' => null,
            'team_members' => null,
        ],
        'features' => [
            'client_portal' => true,
            'custom_branding' => true,
            'advanced_reports' => true,
            'file_attachments' => true,
        ],
    ],
];
