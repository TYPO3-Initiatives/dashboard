<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

/**
 * The AbstractBarChartWidget class is the basic widget class for bar charts.
 * Is it possible to extends this class for own widgets.
 * In your class you have to set $this->chartData with the data to display
 * More information can be found in the documentation.
 * @TODO: Add link to documentation
 */
abstract class AbstractBarChartWidget extends AbstractChartWidget
{
    protected $iconIdentifier = 'dashboard-chartbars';

    protected $chartType = 'bar';

    protected $chartOptions = [
        'maintainAspectRatio' => false,
        'legend' => [
            'display' => false
        ],
        'scales' => [
            'yAxes' => [
                [
                    'ticks' => [
                        'beginAtZero' => true
                    ]
                ]
            ],
            'xAxes' => [
                [
                    'ticks' => [
                        'maxTicksLimit' => 15
                    ]
                ]
            ]
        ]
    ];

    /**
     * @var string
     */
    protected $templateName = 'BarChartWidget';
}
