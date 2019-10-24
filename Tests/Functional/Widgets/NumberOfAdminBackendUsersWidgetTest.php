<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\NumberOfAdminBackendUsersWidget;

class NumberOfAdminBackendUsersWidgetTest extends AbstractWidgetTestCase
{
    protected $widgetClassName = NumberOfAdminBackendUsersWidget::class;

    protected $expectedTitle = 'Number of admin users';
    protected $expectedWidth = 2;
    protected $expectedHeight = 2;
    protected $expectedIconIdentifier = 'dashboard-admin';
    protected $expectedCssFiles = ['typo3conf/ext/dashboard/Resources/Public/CSS/numberWidget.min.css'];

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('Number of admin users', $markup);
        $this->assertStringContainsString('<div class="dashboard-widget-number--number">1</div>', $markup);
        $this->assertStringContainsString('data-identifier="dashboard-admin"', $markup);
    }
}
