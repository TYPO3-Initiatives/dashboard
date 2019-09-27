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
    public function checkInitialStateOfRegistry()
    {
        $registry = new DashboardRegistry();
        $expected = [];
        $expected[] = 'default';
        $this->assertEquals($expected, array_keys($registry->getDashboards()));
    }
}
