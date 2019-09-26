<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Registry;

use TYPO3\CMS\Core\SingletonInterface;

class DashboardRegistry implements SingletonInterface
{
    /**
     * @var array
     */
    protected $dashboards = [];

    /**
     * @param string $key
     * @param string $label
     * @param array $config
     */
    public function registerDashboard(string $key, string $label, array $config = []): void
    {
        $this->dashboards[$key] = ['label' => $label, 'config' => $config];
    }

    /**
     * @return array
     */
    public function getDashboards(): array
    {
        if (!empty($this->dashboards)) {
            return $this->dashboards;
        }

        // Always return a dashboard
        return [
            'default' => [
                'label' => 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default',
                'config' => []
            ]
        ];
    }
}
