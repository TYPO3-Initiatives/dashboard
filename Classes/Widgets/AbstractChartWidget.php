<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

abstract class AbstractChartWidget extends AbstractWidget
{
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
}
