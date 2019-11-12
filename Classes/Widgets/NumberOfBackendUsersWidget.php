<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class NumberOfBackendUsersWidget extends AbstractNumberWidget
{
    public function __construct()
    {
        AbstractNumberWidget::__construct();
        $this->title = 'Number of backend users';
        $this->icon = 'dashboard-user';
        $this->iconIdentifier = 'dashboard-user';
        $this->number = $this->getNumberOfBackendUsers();
    }

    protected function getNumberOfBackendUsers(): int
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('be_users')
            ->select('*')
            ->from('be_users')
            ->execute()
            ->rowCount();
    }
}
