<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\NumberOfBackendUsersWidget;

class NumberOfBackendUsersWidgetTest extends AbstractWidgetTestCase
{
    protected $widgetClassName = NumberOfBackendUsersWidget::class;

    protected $expectedTitle = 'Number of backend users';
    protected $expectedWidth = 2;
    protected $expectedHeight = 2;
    protected $expectedIconIdentifier = 'dashboard-user';
    protected $expectedCssFiles = ['typo3conf/ext/dashboard/Resources/Public/CSS/numberWidget.min.css'];

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('Number of backend users', $markup);
        $this->assertStringContainsString('<div class="dashboard-widget-number--number">2</div>', $markup);
        $this->assertStringContainsString('data-identifier="dashboard-user"', $markup);
    }
}
