<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Configuration;

use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class WidgetGroupTest extends FunctionalTestCase
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
        $widgetGroup = $this->dashboardConfiguration->getWidgetsGroups()['widgetGroup-community'];
        $this->assertSame('widgetGroup-community', $widgetGroup->getIdentifier());
    }

    /**
     * @test
     */
    public function getLabelReturnsAValidString(): void
    {
        $widgetGroup = $this->dashboardConfiguration->getWidgetsGroups()['widgetGroup-community'];
        $this->assertSame('LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widget_group.community', $widgetGroup->getLabel());
    }
}
