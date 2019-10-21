<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ContentChangesWidget extends AbstractListWidget
{
    /**
     * @var string
     */
    protected $templateName = 'contentChanges';

    public function __construct()
    {
        AbstractListWidget::__construct();
        $this->width = 4;
        $this->height = 4;
        $this->title = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.contentchanges.title';
        $this->description = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.contentchanges.description';
        $this->iconIdentifier = 'dashboard-typo3';
    }

    public function prepareData(): void
    {
        $this->items['pendingRecords'] = $this->getPublishStateChangePendingRecords();
        $this->items['changedRecords'] = $this->getMostRecentChangedRecords(count($this->items['pendingRecords']));
    }

    protected function getPublishStateChangePendingRecords(): iterable
    {
        $limit = ceil($this->limit / 2);
        $pendingRecords = $this->getPublishStateChangePendingRecordsFromTable('pages') + $this->getPublishStateChangePendingRecordsFromTable('tt_content');
        usort($pendingRecords, function (array $a, array $b) {
            return min($b['starttime'], $b['endtime']) <=> min($a['starttime'], $a['endtime']);
        });
        return count($pendingRecords) > $limit ? array_slice($pendingRecords, 0, $limit) : $pendingRecords;
    }

    protected function getMostRecentChangedRecords(int $alreadyCollectedItemCount): iterable
    {
        $limit = $this->limit - $alreadyCollectedItemCount;
        $changedRecords = $this->getMostRecentChangedRecordsFromTable('pages') + $this->getMostRecentChangedRecordsFromTable('tt_content');
        usort($changedRecords, function (array $a, array $b) {
            return $b['tstamp'] <=> $a['tstamp'];
        });
        return count($changedRecords) > $limit ? array_slice($changedRecords, 0, $limit) : $changedRecords;
    }

    protected function getPublishStateChangePendingRecordsFromTable(string $table): array
    {
        $labelFieldsForQuery = $this->resolveLabelFieldsForTable($table);
        $now = time();

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder->getRestrictions()->removeByType(StartTimeRestriction::class)->removeByType(EndTimeRestriction::class);
        $query = $queryBuilder->select(...$labelFieldsForQuery)
            ->from($table, 't')
            ->orWhere(
                $queryBuilder->expr()->gte('t.starttime', $queryBuilder->createNamedParameter($now, \PDO::PARAM_INT)),
                $queryBuilder->expr()->gte('t.endtime', $queryBuilder->createNamedParameter($now, \PDO::PARAM_INT))
            )->setMaxResults($this->limit);

        return $this->processItemsQuery($table, $query);
    }

    protected function getMostRecentChangedRecordsFromTable(string $table): array
    {
        $labelFieldsForQuery = $this->resolveLabelFieldsForTable($table);
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $query = $queryBuilder->select('u.username', ...$labelFieldsForQuery)
            ->from($table, 't')
            ->rightJoin(
                't',
                'sys_log',
                'l',
                (string) $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('l.recuid', 't.uid'),
                    $queryBuilder->expr()->eq('l.tablename', $queryBuilder->createNamedParameter($table, \PDO::PARAM_STR))
                )
            )
            ->leftJoin(
                'l',
                'be_users',
                'u',
                'u.uid = l.userid'
            )
            ->orderBy('t.tstamp', 'DESC')
            ->groupBy('t.uid', 't.pid', 't.sys_language_uid', 'u.username', ...$labelFieldsForQuery)
            ->setMaxResults($this->limit);

        return $this->processItemsQuery($table, $query);
    }

    protected function resolveLabelFieldsForTable(string $table): array
    {
        $labelFields = [$GLOBALS['TCA'][$table]['ctrl']['label']] + explode(',', $GLOBALS['TCA'][$table]['ctrl']['label_alt'] ?? '');
        $labelFields = array_filter($labelFields);
        $labelFieldsForQuery = [];
        foreach ($labelFields as $labelField) {
            $labelFieldsForQuery[] = 't.' . $labelField;
        }
        return $labelFieldsForQuery;
    }

    protected function processItemsQuery(string $table, QueryBuilder $query): array
    {
        $iconFactory = $this->getIconFactory();

        $query->addSelect('t.uid', 't.pid', 't.tstamp', 't.sys_language_uid', 't.starttime', 't.endtime');
        if ($table === 'pages') {
            $query->addSelect('t.doktype', 't.is_siteroot');
        } elseif ($table === 'tt_content') {
            $query->addSelect('t.CType');
        }

        $results = $query->execute()->fetchAll();
        if (!$results) {
            return [];
        }
        foreach ($results as &$result) {
            $result['type'] = $table;
            $result['label'] = BackendUtility::getRecordTitle($table, $result);
            $result['icon'] = $iconFactory->getIconForRecord($table, $result, Icon::SIZE_SMALL);
        }

        return $results;
    }

    protected function getIconFactory(): IconFactory
    {
        return GeneralUtility::makeInstance(IconFactory::class);
    }
}
