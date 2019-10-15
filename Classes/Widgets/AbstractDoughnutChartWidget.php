<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * Class AbstractLineChartWidget
 */
abstract class AbstractDoughnutChartWidget extends AbstractChartWidget
{
    protected $iconIdentifier = 'dashboard-chartdoughnut';

    protected $chartType = 'doughnut';

    protected $chartOptions = [
        'maintainAspectRatio' => false,
        'legend' => [
            'display' => false
        ],
        'cutoutPercentage' => 60
    ];

    /**
     * @var string
     */
    protected $templateName = 'DoughnutChartWidget';

    public function __construct()
    {
        $publicResourcesPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath('dashboard')) . 'Resources/Public/';
        $this->cssFiles[] = $publicResourcesPath . 'CSS/doughnutChartWidget.min.css';
    }
}
