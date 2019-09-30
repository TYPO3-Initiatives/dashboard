<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Registry;

use FriendsOfTYPO3\Dashboard\Registry\DashboardRegistry;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class DashboardRegistryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function checkStateOfRegistry(): void
    {
        $registry = new DashboardRegistry();
        $expectedDashboards = ['default'];
        $this->assertEquals($expectedDashboards, array_keys($registry->getDashboards()));

        $registry->registerDashboard('key1', 'label 1', []);
        $expectedDashboards = ['key1'];
        $this->assertEquals($expectedDashboards, array_keys($registry->getDashboards()));

        $registry->registerDashboard('key2', 'label 2', []);
        $expectedDashboards = ['key1', 'key2'];
        $this->assertEquals($expectedDashboards, array_keys($registry->getDashboards()));
    }
}
