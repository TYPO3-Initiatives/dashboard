<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

/**
 * Class AbstractLineChartWidget
 */
abstract class AbstractLineChartWidget extends AbstractChartWidget
{
    protected $iconIdentifier = 'dashboard-chartline';

    protected $chartType = 'line';

    protected $chartOptions = [
        'responsive' => true,
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
    protected $templateName = 'LineChartWidget';
}
