<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\T3NewsWidget;

class T3NewsWidgetTest extends AbstractWidgetTestCase
{
    protected $widgetClassName = T3NewsWidget::class;

    protected $expectedTitle = 'TYPO3 News';
    protected $expectedIconIdentifier = 'dashboard-typo3';
    protected $expectedHeight = 6;
    protected $expectedWidth = 4;
    protected $expectedCssFiles = ['typo3conf/ext/dashboard/Resources/Public/CSS/rssWidget.min.css'];

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('TYPO3 News', $markup);
        $this->assertStringContainsString('<table class="widget-rss widget-table">', $markup);
        $this->assertStringContainsString('<a class="widget-rss-title"', $markup);
        $this->assertStringContainsString('<span class="widget-rss-date">', $markup);
        $this->assertStringContainsString('<p class="widget-rss-description">', $markup);
    }
}
