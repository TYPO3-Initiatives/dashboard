<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class NumberOfAdminBackendUsersWidget
 */
class NumberOfAdminBackendUsersWidget extends AbstractNumberWidget
{
    public function __construct()
    {
        AbstractNumberWidget::__construct();
        $this->width = 2;
        $this->height = 2;
        $this->title = 'Number of admin users';
        $this->icon = 'dashboard-admin';
        $this->iconIdentifier = 'dashboard-admin';
        $this->number = $this->getNumberOfAdminBackendUsers();
    }

    protected function getNumberOfAdminBackendUsers(): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
        return $queryBuilder
            ->select('*')
            ->from('be_users')
            ->where(
                $queryBuilder->expr()->eq('admin', 1)
            )
            ->execute()
            ->rowCount();
    }
}
