<?php
return [
    'dashboard' => [
        'path' => '/ext/dashboard/active',
        'target' => \FriendsOfTYPO3\Dashboard\Controller\DashboardController::class . '::handleRequest',
    ],
];
