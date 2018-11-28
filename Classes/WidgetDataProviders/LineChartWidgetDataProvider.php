<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

class LineChartWidgetDataProvider extends AbstractChartWidgetDataProvider
{
    protected function initializeData(): void
    {
        $data = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'datasets' => [
                [
                    'label' => 'Dataset #1',
                    'data' => [rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30)],
                    'fill' => false,
                    'borderColor' => 'rgb(70,130,180)',
                    'lineTension' => 0.1
                ]
            ]
        ];

        $this->setProperty('chartType', 'line');
        $this->setProperty('chartHeight', 100);
        $this->setProperty('chartData', $data);
    }
}
