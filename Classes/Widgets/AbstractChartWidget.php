<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\Interfaces\AdditionalCssInterface;
use FriendsOfTYPO3\Dashboard\Widgets\Interfaces\EventDataInterface;
use FriendsOfTYPO3\Dashboard\Widgets\Interfaces\RequireJsModuleInterface;

/**
 * The AbstractChartWidget class is the basic widget class for all chart widgets
 * Is it possible to extends this class for own widgets, but EXT:dashboard provide
 * also some more special chart types of widgets. For more details, please check:
 * @see AbstractBarChartWidget
 * @see AbstractDoughnutChartWidget
 * @see AbstractLineChartWidget
 * More information can be found in the documentation.
 * @TODO: Add link to documentation
 */
abstract class AbstractChartWidget extends AbstractWidget implements AdditionalCssInterface, RequireJsModuleInterface, EventDataInterface
{
    protected $chartType = '';

    protected $chartData = [];

    protected $chartOptions = [];

    protected $eventData = [];

    protected $chartColors = ['#f49702', '#a4276a', '#1a568f', '#4c7e3a', '#69bbb5'];

    protected $additionalClasses = 'dashboard-item--chart';

    protected $iconIdentifier = 'dashboard-chart';

    /**
     * Method to set all data for the chart in $this->eventData
     */
    abstract protected function prepareChartData(): void;

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

    /**
     * This method returns an array with paths to required CSS files.
     * e.g. ['EXT:myext/Resources/Public/Css/my_widget.css']
     * @return array
     */
    public function getCssFiles(): array
    {
        return ['EXT:dashboard/Resources/Public/CSS/Dist/Chart.min.css'];
    }

    public function getRequireJsModules(): array
    {
        return [
            'TYPO3/CMS/Dashboard/ChartInitializer',
        ];
    }
}
