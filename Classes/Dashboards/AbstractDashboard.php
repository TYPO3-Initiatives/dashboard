<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Dashboards;

use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use FriendsOfTYPO3\Dashboard\Widgets\AbstractWidget;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Widget
 * This class represents the instance of a dashboard.
 * @internal
 */
abstract class AbstractDashboard
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * AbstractDashboard constructor.
     * @param string $identifier
     * @param string $label
     * @param array $configuration
     */
    public function __construct(string $identifier, string $label, array $configuration)
    {
        $this->identifier = $identifier;
        $this->label = $label;
        $this->configuration = $configuration;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * @return AbstractWidget[]
     */
    public function getWidgets(): array
    {
        $widgets = [];
        $widgetConfigurations = GeneralUtility::makeInstance(DashboardConfiguration::class)->getWidgets();
        foreach ($this->configuration['widgets'] ?? [] as $widgetConfiguration) {
            $widgets[] = GeneralUtility::makeInstance($widgetConfigurations[$widgetConfiguration['key']]->getClassname());
        }
        return $widgets;
    }
}
