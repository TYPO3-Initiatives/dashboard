<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

class BarChartWidgetDataProvider extends AbstractChartWidgetDataProvider
{
    protected function initializeData(): void
    {
        $data = [
            'labels' => ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
            'datasets' => [
                [
                    'label' => 'Dataset #1',
                    'data' => [rand(0,30), rand(0,30), rand(0,30), rand(0,30), rand(0,30)],
                    'backgroundColor' => ['rgb(255, 99, 132)','rgb(54, 162, 235)','rgb(255, 205, 86)','rgb(34,139,34)','rgb(138,43,226)']
                ]
            ]
        ];

        $this->setProperty('chartType', 'bar');
        $this->setProperty('chartHeight', 100);
        $this->setProperty('chartData', $data);
        $this->setProperty('chartDescription', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque vulputate euismod.');
    }
}
