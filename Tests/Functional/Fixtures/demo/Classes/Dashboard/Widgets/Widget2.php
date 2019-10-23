<?php
declare(strict_types=1);

namespace DEMO\Demo\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\AbstractWidget;

class Widget2 extends AbstractWidget
{
    protected $extensionKey = 'demo';

    protected $title = 'Title: Widget 2';
    protected $iconIdentifier = 'demo-widget2';

    /**
     * @var string
     */
    protected $templateName = 'Widget2';
    public function prepareData(): void
    {
        // TODO: Implement prepareData() method.
    }
}
