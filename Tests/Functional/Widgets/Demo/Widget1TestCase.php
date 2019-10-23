<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets\Demo;

use DEMO\Demo\Dashboard\Widgets\Widget1;
use FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets\AbstractWidgetTestCase;

class Widget1TestCase extends AbstractWidgetTestCase
{
    protected $widgetClassName = Widget1::class;

    protected $expectedTitle = 'Title: Widget 1';
    protected $expectedIconIdentifier = 'demo-widget1';
    protected $expectedHeight = 2;
    protected $expectedWidth = 2;

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('Title: Widget 1', $markup);
        $this->assertStringContainsString('Content: Widget 1', $markup);
    }
}
