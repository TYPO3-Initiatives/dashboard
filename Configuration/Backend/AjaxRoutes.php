<?php

return [
    // Get data
    'ext-dashboard-get-widget-data' => [
        'path' => '/ext/dashboard/widget/data',
        'target' => \Haassie\Dashboard\Controller\WidgetDataAjaxController::class . '::getData'
    ]
];
