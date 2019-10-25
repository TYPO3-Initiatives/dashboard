<?php
declare(strict_types=1);

namespace DEMO\Demo\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\AbstractWidget;

class Widget1 extends AbstractWidget
{
    protected $extensionKey = 'demo';
    protected $title = 'Title: Widget 1';
    protected $iconIdentifier = 'demo-widget1';
    protected $templateName = 'Widget1';
}
