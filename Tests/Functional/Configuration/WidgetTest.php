<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Configuration;

use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use FriendsOfTYPO3\Dashboard\Widgets\NumberOfBackendUsersWidget;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class WidgetTest extends FunctionalTestCase
{
    /**
     * @var DashboardConfiguration
     */
    protected $dashboardConfiguration;

    public function setUp(): void
    {
        $this->testExtensionsToLoad[] = 'typo3conf/ext/dashboard';
        parent::setUp();
        $this->dashboardConfiguration = GeneralUtility::makeInstance(DashboardConfiguration::class);
    }

    /**
     * @test
     */
    public function getIdentifierReturnsAValidString(): void
    {
        $widget = $this->dashboardConfiguration->getWidgets()['numberOfBackendUsers'];
        $this->assertSame('numberOfBackendUsers', $widget->getIdentifier());
    }

    /**
     * @test
     */
    public function getClassnameReturnsAValidString(): void
    {
        $widget = $this->dashboardConfiguration->getWidgets()['numberOfBackendUsers'];
        $this->assertSame(NumberOfBackendUsersWidget::class, $widget->getClassname());
    }

    /**
     * @test
     */
    public function WidgetReturnsAValidArray(): void
    {
        $widget = $this->dashboardConfiguration->getWidgets()['numberOfBackendUsers'];
        $this->assertSame(['widgetGroup-system'], $widget->getGroups());
    }
}
