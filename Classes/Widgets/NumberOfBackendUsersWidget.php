<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class NumberOfBackendUsersWidget
 */
class NumberOfBackendUsersWidget extends AbstractNumberWidget
{
    public function __construct()
    {
        AbstractNumberWidget::__construct();
        $this->title = 'Number of backend users';
        $this->icon = 'status-user-backend';
    }

    public function prepareData(): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_users');
        $this->number = $queryBuilder->select('*')->from('be_users')->execute()->rowCount();
    }
}
