<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Dashboards;

use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use FriendsOfTYPO3\Dashboard\Dashboards\AbstractDashboard;
use FriendsOfTYPO3\Dashboard\Dashboards\DashboardRepository;
use FriendsOfTYPO3\Dashboard\Widgets\AbstractWidget;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class DashboardRepositoryTest extends FunctionalTestCase
{
    /**
     * @var DashboardRepository
     */
    protected $subject;

    public function setUp(): void
    {
        $this->testExtensionsToLoad[] = 'typo3conf/ext/dashboard';
        parent::setUp();
        $this->subject = GeneralUtility::makeInstance(DashboardRepository::class);
    }

    /**
     * @test
     */
    public function getAllDashboardsReturnsEmptyArrayWithEmptyDatabase(): void
    {
        $this->assertSame([], $this->subject->getAllDashboards());
    }

    /**
     * @test
     */
    public function getAllDashboardsReturnsArrayOneDashboard(): void
    {
        $this->importDataSet(__DIR__ . '/../Fixtures/sys_dashboards_one_dashboard.xml');
        $dashboards = $this->subject->getAllDashboards();
        $this->assertCount(1, $dashboards);
        $this->assertInstanceOf(AbstractDashboard::class, $dashboards[0]);
        $this->assertSame('a8a9ad23c27c51640738fcae687563243af5a58f', $dashboards[0]->getIdentifier());
        $this->assertSame('LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default', $dashboards[0]->getLabel());
        $this->assertCount(7, $dashboards[0]->getConfiguration()['widgets']);
        $this->assertCount(7, $dashboards[0]->getWidgets());
        foreach ($dashboards[0]->getWidgets() as $widget) {
            $this->assertInstanceOf(AbstractWidget::class, $widget);
        }
    }

    /**
     * @test
     */
    public function getAllDashboardsReturnsArrayTwoDashboard(): void
    {
        $this->importDataSet(__DIR__ . '/../Fixtures/sys_dashboards_two_dashboard.xml');
        $dashboards = $this->subject->getAllDashboards();
        $this->assertCount(2, $dashboards);
        $this->assertInstanceOf(AbstractDashboard::class, $dashboards[0]);
        $this->assertSame('a8a9ad23c27c51640738fcae687563243af5a58f', $dashboards[0]->getIdentifier());
        $this->assertSame('LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default', $dashboards[0]->getLabel());
        $this->assertCount(7, $dashboards[0]->getConfiguration()['widgets']);
        $this->assertInstanceOf(AbstractDashboard::class, $dashboards[1]);
        $this->assertSame('b310c3f6568b2bea26fc1c14b225fee2dee4bad4', $dashboards[1]->getIdentifier());
        $this->assertSame('LLL:EXT:demo/Resources/Private/Language/locallang_be.xlf:dashboard', $dashboards[1]->getLabel());
        $this->assertCount(2, $dashboards[1]->getConfiguration()['widgets']);
    }

    /**
     * @test
     */
    public function getDashboardByIdentifierReturnsEmptyArrayWithEmptyDatabase(): void
    {
        $this->assertNull($this->subject->getDashboardByIdentifier('foo'));
    }

    /**
     * @test
     */
    public function getDashboardByIdentifierReturnsArrayOneDashboard(): void
    {
        $this->importDataSet(__DIR__ . '/../Fixtures/sys_dashboards_one_dashboard.xml');
        $dashboard = $this->subject->getDashboardByIdentifier('a8a9ad23c27c51640738fcae687563243af5a58f');
        $this->assertInstanceOf(AbstractDashboard::class, $dashboard);
        $this->assertSame('a8a9ad23c27c51640738fcae687563243af5a58f', $dashboard->getIdentifier());
        $this->assertSame('LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default', $dashboard->getLabel());
        $this->assertCount(7, $dashboard->getConfiguration()['widgets']);
        $this->assertCount(7, $dashboard->getWidgets());
        foreach ($dashboard->getWidgets() as $widget) {
            $this->assertInstanceOf(AbstractWidget::class, $widget);
        }
    }

    /**
     * @test
     */
    public function createDashboardCreatesANewDashboardInDatabase(): void
    {
        $this->assertCount(0, $this->subject->getAllDashboards());
        $dashboard = $this->subject->createDashboard(
            GeneralUtility::makeInstance(DashboardConfiguration::class)->getDashboards()['dashboard-default'],
            'default'
        );
        $this->assertInstanceOf(AbstractDashboard::class, $dashboard);
        $this->assertCount(1, $this->subject->getAllDashboards());
    }

    /**
     * @throws \TYPO3\TestingFramework\Core\Exception
     * @test
     */
    public function updateDashboardSettingsChangesDashboardLabel(): void
    {
        $this->importDataSet(__DIR__ . '/../Fixtures/sys_dashboards_one_dashboard.xml');

        $this->subject->updateDashboardSettings(
            'a8a9ad23c27c51640738fcae687563243af5a58f',
            ['label' => 'Renamed Dashboard']
        );
        $dashboard = $this->subject->getDashboardByIdentifier('a8a9ad23c27c51640738fcae687563243af5a58f');

        $this->assertEquals('Renamed Dashboard', $dashboard->getLabel());
    }

    /**
     * @test
     */
    public function createWidgetRepresentationReturnsEmptyArrayForUnknownConfiguration(): void
    {
        $this->assertSame([], $this->subject->createWidgetRepresentation('foo'));
    }

    /**
     * @test
     */
    public function createWidgetRepresentationReturnsArrayForKnownConfiguration(): void
    {
        $this->assertSame([
            'identifier' => 'numberOfBackendUsers',
            'height' => 2,
            'width' => 2,
            'title' => 'Number of backend users',
            'additionalClasses' => '',
            'config' => [],
        ], $this->subject->createWidgetRepresentation('numberOfBackendUsers'));
    }

    /**
     * @test
     */
    public function updateWidgetsUpdateWidgetsForGivenDashboard(): void
    {
        $this->importDataSet(__DIR__ . '/../Fixtures/sys_dashboards_one_dashboard.xml');
        $dashboard = $this->subject->getDashboardByIdentifier('a8a9ad23c27c51640738fcae687563243af5a58f');
        $this->assertInstanceOf(AbstractDashboard::class, $dashboard);
        $this->assertCount(7, $dashboard->getConfiguration()['widgets']);
        $this->subject->updateWidgets($dashboard, []);
        $dashboard = $this->subject->getDashboardByIdentifier('a8a9ad23c27c51640738fcae687563243af5a58f');
        $this->assertInstanceOf(AbstractDashboard::class, $dashboard);
        $this->assertCount(0, $dashboard->getConfiguration()['widgets']);
    }
}
