<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets\Demo;

use DEMO\Demo\Dashboard\Widgets\Widget3;
use FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets\AbstractWidgetTestCase;

class Widget3Test extends AbstractWidgetTestCase
{
    protected $widgetClassName = Widget3::class;

    protected $expectedTitle = 'Title: Widget 3';
    protected $expectedIconIdentifier = 'demo-widget3';
    protected $expectedHeight = 4;
    protected $expectedWidth = 2;
    protected $expectedAdditionalClasses = 'dashboard-item--chart';
    protected $expectedCssFiles = [
        'EXT:dashboard/Resources/Public/CSS/Dist/Chart.min.css',
        'EXT:dashboard/Resources/Public/CSS/doughnutChartWidget.min.css'
    ];
    protected $expectedRequireJsModules = ['TYPO3/CMS/Dashboard/ChartInitializer'];

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('Title: Widget 3', $markup);
        $this->assertStringContainsString('<div class="widget-chart-doughnut">', $markup);
        $this->assertStringContainsString('<canvas id="canvas"></canvas>', $markup);
        $this->assertStringContainsString('<div class="widget-doughnut--value">', $markup);
        $this->assertStringContainsString('<div class="widget-doughnut--meta">', $markup);
    }
}
