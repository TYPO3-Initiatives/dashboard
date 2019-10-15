<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LastLoginsWidget extends AbstractListWidget
{
    /**
     * @var string
     */
    protected $templateName = 'LastLogins';

    public function __construct()
    {
        AbstractListWidget::__construct();
        $this->width = 4;
        $this->height = 4;
        $this->title = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.lastLogins.title';
        $this->description = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.lastLogins.description';
        $this->iconIdentifier = 'dashboard-signin';
    }

    public function prepareData(): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_log');
        $statement = $queryBuilder
            ->select('userid', 'tstamp', 'ip')
            ->from('sys_log')
            ->where(
                $queryBuilder->expr()->eq('type', 255)
            )
            ->orderBy('tstamp', 'DESC')
            ->setMaxResults(5)
            ->execute();

        while ($row = $statement->fetch()) {
            $user = BackendUtility::getRecord('be_users', $row['userid']);

            $this->items[] = ['user' => $user['username'], 'tstamp' => $row['tstamp'], 'ip' => $row['ip']];
        }
    }
}
