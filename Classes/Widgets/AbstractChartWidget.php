<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

abstract class AbstractChartWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected $chartType = '';

    /**
     * @var array
     */
    protected $chartData = [];

    /**
     * @var array
     */
    protected $chartOptions = [];

    /**
     * @var array
     */
    protected $chartColors = ['#f49702'];

    /**
     * AbstractChartWidget constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->cssFiles[] = $this->publicResourcesPath . 'CSS/Dist/Chart.min.css';
        $this->jsFiles['chartjs'] = $this->publicResourcesPath . 'JavaScript/Dist/Chart.min';
        $this->jsFiles['chartinitializer'] = $this->publicResourcesPath . 'JavaScript/ChartInitializer';
    }

    /**
     * Method to set all data for the chart
     */
    protected function prepareChartData(): void
    {

    }

    /**
     * @return array
     */
    public function retrieveJavaScriptCallbacks(): array
    {
        $this->prepareChartData();

        $this->javaScriptCallbacks['ChartInitializer.init'] = [
            'config' => [
                'type' => $this->chartType,
                'data' => $this->chartData,
                'options' => $this->chartOptions
            ]
        ];

        return $this->javaScriptCallbacks;
    }
}
