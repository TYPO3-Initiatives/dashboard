<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\LastLoginsWidget;

class LastLoginsWidgetTest extends AbstractWidgetTestCase
{
    protected $widgetClassName = LastLoginsWidget::class;

    protected $expectedTitle = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.lastLogins.title';
    protected $expectedDescription = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.lastLogins.description';
    protected $expectedWidth = 4;
    protected $expectedHeight = 4;
    protected $expectedIconIdentifier = 'dashboard-signin';

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('Last 5 backend logins', $markup);
        $this->assertStringContainsString('<table class="widget-table">', $markup);
        $this->assertStringContainsString('<th>Date</th>', $markup);
        $this->assertStringContainsString('<th>User</th>', $markup);
        $this->assertStringContainsString('<th>IP-address</th>', $markup);
        $this->assertStringContainsString('<td>29-11-1973 21:33</td>', $markup);
        $this->assertStringContainsString('<td>kasper</td>', $markup);
        $this->assertStringContainsString('<td>127.0.0.0</td>', $markup);
    }
}
