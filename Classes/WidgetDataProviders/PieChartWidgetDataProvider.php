<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

class PieChartWidgetDataProvider extends AbstractChartWidgetDataProvider
{
    protected function initializeData(): void
    {
        $data = [
            'labels' => ['Red', 'Blue', 'Yellow'],
            'datasets' => [
                [
                    'data' => [rand(0,30), rand(0,30), rand(0,30)],
                    'backgroundColor' => ['rgb(255, 99, 132)','rgb(54, 162, 235)','rgb(255, 205, 86)']
                ]
            ]
        ];

        $this->setProperty('chartData', $data);
        $this->setProperty('chartDescription', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pellentesque vulputate euismod. Duis eleifend, leo porta tempus luctus, risus mi semper nunc, finibus vehicula lectus orci nec nulla. Maecenas iaculis congue tellus, id varius mi euismod a. Suspendisse potenti. Donec sodales risus vel elementum facilisis.');
    }
}
