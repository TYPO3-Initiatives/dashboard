<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\SysLogErrorsWidget;

class SysLogErrorsWidgetTest extends AbstractWidgetTestCase
{
    protected $widgetClassName = SysLogErrorsWidget::class;

    protected $expectedTitle = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.sysLogErrors.title';
    protected $expectedWidth = 4;
    protected $expectedHeight = 4;
    protected $expectedAdditionalClasses = 'dashboard-item--chart';
    protected $expectedIconIdentifier = 'dashboard-chartbars';
    protected $expectedCssFiles = ['EXT:dashboard/Resources/Public/CSS/Dist/Chart.min.css'];
    protected $expectedRequireJsModules = ['TYPO3/CMS/Dashboard/ChartInitializer'];

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('Number of errors in system log', $markup);
        $this->assertStringContainsString('<div class="widget-chart">', $markup);
        $this->assertStringContainsString('<canvas id="canvas"></canvas>', $markup);
        $eventData = $this->widget->getEventData();
        $this->assertIsArray($eventData);
        $this->assertIsArray($eventData['graphConfig']);
    }
}
