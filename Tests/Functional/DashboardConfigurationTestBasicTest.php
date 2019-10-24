<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional;

use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use FriendsOfTYPO3\Dashboard\Widgets\DocumentationWidget;
use FriendsOfTYPO3\Dashboard\Widgets\LastLoginsWidget;
use FriendsOfTYPO3\Dashboard\Widgets\NumberOfAdminBackendUsersWidget;
use FriendsOfTYPO3\Dashboard\Widgets\NumberOfBackendUsersWidget;
use FriendsOfTYPO3\Dashboard\Widgets\PagesWithoutDescriptionWidget;
use FriendsOfTYPO3\Dashboard\Widgets\SysLogErrorsWidget;
use FriendsOfTYPO3\Dashboard\Widgets\T3NewsWidget;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DashboardConfigurationTestBasicTest extends AbstractDashboardConfigurationTest
{
    public function setUp(): void
    {
        $this->testExtensionsToLoad[] = 'typo3conf/ext/dashboard';
        parent::setUp();
        $this->subject = GeneralUtility::makeInstance(DashboardConfiguration::class);
    }

    /**
     * @return array
     */
    public function getDashboardsDataProvider(): array
    {
        return [
            'dashboard-default' => ['dashboard-default', false, 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default', 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default.description', 'dashboard-dashboard', 7],
            'dashboard-empty' => ['dashboard-empty', false, 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.empty', 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.empty.description', 'dashboard-dashboard', 0],
        ];
    }

    /**
     * @return array
     */
    public function getWidgetsDataProvider(): array
    {
        return [
            'numberOfBackendUsers' => ['numberOfBackendUsers', NumberOfBackendUsersWidget::class],
            'numberOfAdminBackendUsers' => ['numberOfAdminBackendUsers', NumberOfAdminBackendUsersWidget::class],
            'lastLogins' => ['lastLogins', LastLoginsWidget::class],
            'pagesWithoutDescription' => ['pagesWithoutDescription', PagesWithoutDescriptionWidget::class],
            'sysLogErrors' => ['sysLogErrors', SysLogErrorsWidget::class],
            't3News' => ['t3News', T3NewsWidget::class],
            'documentation' => ['documentation', DocumentationWidget::class],
        ];
    }
}
