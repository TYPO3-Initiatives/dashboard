<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

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

    protected $additionalClasses = 'dashboard-item--chart';

    protected $iconIdentifier = 'dashboard-chart';

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
        // This method need to be implemented by the final class
    }

    /**
     * @return array
     */
    public function getEventData(): array
    {
        $this->prepareChartData();

        $this->eventData['graphConfig'] = [
            'type' => $this->chartType,
            'data' => $this->chartData,
            'options' => $this->chartOptions
        ];

        return $this->eventData;
    }
}
