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
        $this->width = 2;
        $this->height = 2;
        $this->title = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.pagesWithoutDescription.title';
    }

    public function prepareData(): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $statement = $queryBuilder
            ->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('description', $queryBuilder->createNamedParameter(''))
            )
            ->setMaxResults(5)
            ->execute();

        while ($row = $statement->fetch()) {
            $this->items[] = ['id' => $row['uid'], 'page' => $row['title'], 'slug' => $row['slug']];
        }
    }
}
