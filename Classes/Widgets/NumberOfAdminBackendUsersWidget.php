<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class NumberOfAdminBackendUsersWidget
 * @package FriendsOfTYPO3\Dashboard\Widgets
 */
class NumberOfAdminBackendUsersWidget extends AbstractNumberWidget
{
    public function __construct()
    {
        AbstractNumberWidget::__construct();
        $this->width = 1;
        $this->height = 1;
        $this->title = 'Number of admin users';
        $this->icon = 'status-user-admin';
    }

    public function prepareData(): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
        $this->number = $queryBuilder
            ->select('*')
            ->from('be_users')
            ->where(
                $queryBuilder->expr()->eq('admin', 1)
            )
            ->execute()
            ->rowCount();
    }
}
