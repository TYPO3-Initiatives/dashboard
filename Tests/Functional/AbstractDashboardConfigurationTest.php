<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional;

use FriendsOfTYPO3\Dashboard\Configuration\DashboardTemplate;
use FriendsOfTYPO3\Dashboard\Configuration\Widget;
use FriendsOfTYPO3\Dashboard\Configuration\WidgetGroup;
use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

abstract class AbstractDashboardConfigurationTest extends FunctionalTestCase
{
    /**
     * @var DashboardConfiguration
     */
    protected $subject;

    abstract public function getDashboardsDataProvider(): array;
    abstract public function getWidgetsDataProvider(): array;
    abstract public function getWidgetGroupsDataProvider(): array;

    /**
     * @test
     * @dataProvider getDashboardsDataProvider
     * @param string $identifier
     * @param bool $excludeFromWizard
     * @param string $label
     * @param string $description
     * @param string $iconIdentifier
     * @param int $amountOfWidgets
     */
    public function getDashboardsReturnsDashboardConfiguration(string $identifier, bool $excludeFromWizard, string $label, string $description, string $iconIdentifier, int $amountOfWidgets): void
    {
        $dashboards = $this->subject->getDashboards();
        $this->assertInstanceOf(DashboardTemplate::class, $dashboards[$identifier]);
        $this->assertSame($identifier, $dashboards[$identifier]->getIdentifier());
        $this->assertSame($excludeFromWizard, $dashboards[$identifier]->getExcludeFromWizard());
        $this->assertSame($label, $dashboards[$identifier]->getLabel());
        $this->assertSame($description, $dashboards[$identifier]->getDescription());
        $this->assertSame($iconIdentifier, $dashboards[$identifier]->getIconIdentifier());
        $this->assertCount($amountOfWidgets, $dashboards[$identifier]->getWidgets());
    }

    /**
     * @test
     * @dataProvider getWidgetsDataProvider
     * @param string $identifier
     * @param string $className
     */
    public function getWidgetsReturnsWidgetConfiguration(string $identifier, string $className): void
    {
        $widgets = $this->subject->getWidgets();
        $this->assertInstanceOf(Widget::class, $widgets[$identifier]);
        $this->assertSame($identifier, $widgets[$identifier]->getIdentifier());
        $this->assertSame($className, $widgets[$identifier]->getClassname());
    }

    /**
     * @test
     * @dataProvider getWidgetGroupsDataProvider
     * @param string $identifier
     * @param string $label
     */
    public function getWidgetGroupsReturnsWidgetConfiguration(string $identifier, string $label): void
    {
        $widgetsGroups = $this->subject->getWidgetsGroups();
        $this->assertInstanceOf(WidgetGroup::class, $widgetsGroups[$identifier]);
        $this->assertSame($identifier, $widgetsGroups[$identifier]->getIdentifier());
        $this->assertSame($label, $widgetsGroups[$identifier]->getLabel());
    }
}
