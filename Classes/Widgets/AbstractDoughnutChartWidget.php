<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

/**
 * The AbstractDoughnutChartWidget class is the basic widget class for doughnut charts.
 * Is it possible to extends this class for own widgets.
 * In your class you have to set $this->chartData with the data to display
 * More information can be found in the documentation.
 * @TODO: Add link to documentation
 */
abstract class AbstractDoughnutChartWidget extends AbstractChartWidget
{
    protected $iconIdentifier = 'dashboard-pie';

    protected $chartType = 'doughnut';

    protected $chartOptions = [
        'maintainAspectRatio' => false,
        'legend' => [
            'display' => false
        ],
        'cutoutPercentage' => 60
    ];

    protected $templateName = 'DoughnutChartWidget';

    /**
     * This method returns an array with paths to required CSS files.
     * e.g. ['EXT:myext/Resources/Public/Css/my_widget.css']
     * @return array
     */
    public function getCssFiles(): array
    {
        $cssFiles = parent::getCssFiles();
        $cssFiles[] = 'EXT:dashboard/Resources/Public/CSS/doughnutChartWidget.min.css';
        return $cssFiles;
    }
}
