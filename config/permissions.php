<?php

return [
    [
        'name' => 'SUBSCRIPTION',
        'flag' => 'plugin.subscription',
    ],
    [
        'name' => 'SUBSCRIPTION',
        'flag' => 'subscription.index',
        'parent_flag' => 'plugin.subscription',
    ],
    [
        'name' => 'Create',
        'flag' => 'subscription.create',
        'parent_flag' => 'subscription.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'subscription.edit',
        'parent_flag' => 'subscription.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'subscription.destroy',
        'parent_flag' => 'subscription.index',
    ],
];
