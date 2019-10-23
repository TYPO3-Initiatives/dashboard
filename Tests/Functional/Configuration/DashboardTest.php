<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Configuration;

use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class DashboardTest extends FunctionalTestCase
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
        $dashboard = $this->dashboardConfiguration->getDashboards()['dashboard-default'];
        $this->assertSame('dashboard-default', $dashboard->getIdentifier());
    }

    /**
     * @test
     */
    public function getExcludeFromWizardReturnsFalse(): void
    {
        $dashboard = $this->dashboardConfiguration->getDashboards()['dashboard-default'];
        $this->assertFalse($dashboard->getExcludeFromWizard());
    }

    /**
     * @test
     */
    public function getIconIdentifierReturnsAValidString(): void
    {
        $dashboard = $this->dashboardConfiguration->getDashboards()['dashboard-default'];
        $this->assertSame('dashboard-dashboard', $dashboard->getIconIdentifier());
    }

    /**
     * @test
     */
    public function getLabelIdentifierReturnsAValidString(): void
    {
        $dashboard = $this->dashboardConfiguration->getDashboards()['dashboard-default'];
        $this->assertSame('LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default', $dashboard->getLabel());
    }

    /**
     * @test
     */
    public function getDescriptionIdentifierReturnsAValidString(): void
    {
        $dashboard = $this->dashboardConfiguration->getDashboards()['dashboard-default'];
        $this->assertSame('LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default.description', $dashboard->getDescription());
    }

    /**
     * @test
     */
    public function getWidgetsReturnsAnArray(): void
    {
        $dashboard = $this->dashboardConfiguration->getDashboards()['dashboard-default'];
        $this->assertCount(7, $dashboard->getWidgets());
        $this->assertSame(['t3News', 'documentation', 'numberOfBackendUsers', 'numberOfAdminBackendUsers', 'lastLogins', 'pagesWithoutDescription', 'sysLogErrors'], $dashboard->getWidgets());
    }
}
