<?php
return [
    // Get data
    'ext-dashboard-get-widget-content' => [
        'path' => '/ext/dashboard/widget/content',
        'target' => \FriendsOfTYPO3\Dashboard\Controller\WidgetAjaxController::class . '::getContent'
    ],
    // Save positions
    'ext-dashboard-save-widget-positions' => [
        'path' => '/ext/dashboard/widget/positions/save',
        'target' => \FriendsOfTYPO3\Dashboard\Controller\WidgetAjaxController::class . '::savePositions'
    ],
];
