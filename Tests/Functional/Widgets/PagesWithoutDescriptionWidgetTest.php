<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\PagesWithoutDescriptionWidget;

class PagesWithoutDescriptionWidgetTest extends AbstractWidgetTestCase
{
    protected $widgetClassName = PagesWithoutDescriptionWidget::class;

    protected $expectedTitle = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.pagesWithoutDescription.title';
    protected $expectedWidth = 4;
    protected $expectedHeight = 4;
    protected $expectedIconIdentifier = 'dashboard-bars';

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('Pages without a meta description', $markup);
        $this->assertStringContainsString('<table class="widget-table">', $markup);
        $this->assertStringContainsString('<th>Page</th>', $markup);
        $this->assertStringContainsString('<th>Slug</th>', $markup);
        $this->assertStringContainsString('<td>Page 1</td>', $markup);
        $this->assertStringContainsString('<td>/page1</td>', $markup);
        $this->assertStringContainsString('<td>Page 3</td>', $markup);
        $this->assertStringContainsString('<td>/page3</td>', $markup);
    }
}
