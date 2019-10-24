<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

/**
 * Class AbstractBarChartWidget
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
