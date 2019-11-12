<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PagesWithoutDescriptionWidget extends AbstractListWidget
{
    /**
     * @var string
     */
    protected $templateName = 'PagesWithoutDescription';

    public function __construct()
    {
        AbstractListWidget::__construct();
        $this->width = 4;
        $this->height = 4;
        $this->limit = 5;
        $this->title = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.pagesWithoutDescription.title';
        $this->getDataForWidget();
    }

    protected function getDataForWidget(): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $constraints = [
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->eq('description', $queryBuilder->createNamedParameter('')),
                $queryBuilder->expr()->isNull('description')
            ),
        ];
        if (isset($GLOBALS['TCA']['pages']['columns']['no_index'])) {
            // Column is potentially not defined; added by system extension EXT:seo that is not (should not) be a dependency.
            $constraints[] = $queryBuilder->expr()->eq('no_index', 0);
        }
        $queryBuilder
            ->select('*')
            ->from('pages')
            ->where(...$constraints)
            ->orderBy('tstamp', 'DESC');

        $this->totalItems = $queryBuilder->execute()->rowCount();

        $statement = $queryBuilder->setMaxResults($this->limit)->execute();
        while ($row = $statement->fetch()) {
            $this->items[] = ['id' => $row['uid'], 'page' => $row['title'], 'slug' => $row['slug']];
        }
    }
}
