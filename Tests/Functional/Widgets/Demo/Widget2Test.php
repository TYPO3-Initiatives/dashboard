<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets\Demo;

use DEMO\Demo\Dashboard\Widgets\Widget2;
use FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets\AbstractWidgetTestCase;

class Widget2Test extends AbstractWidgetTestCase
{
    protected $widgetClassName = Widget2::class;

    protected $expectedTitle = 'Title: Widget 2';
    protected $expectedIconIdentifier = 'demo-widget2';
    protected $expectedHeight = 2;
    protected $expectedWidth = 2;

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('Title: Widget 2', $markup);
        $this->assertStringContainsString('Content: Widget 2', $markup);
    }
}
