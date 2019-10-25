<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SysLogErrorsWidget extends AbstractBarChartWidget
{
    protected $title = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.sysLogErrors.title';

    protected $width = 4;

    protected $height = 4;

    protected function prepareChartData(): void
    {
        $this->chartData = $this->getChartData();
    }

    protected function getChartData(): array
    {
        $period = 'lastMonth';

        $labels = [];
        $data = [];

        // @TODO: the next block is not reached yet.
        // @TOOO: this block is prepared for having a configuration option with two periods
        // @codeCoverageIgnoreStart
        if ($period === 'lastWeek') {
            $data = $this->calculateDataForLastDays(7);
        }
        // @codeCoverageIgnoreEnd

        if ($period === 'lastMonth') {
            $data = $this->calculateDataForLastDays(31);
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => $this->getLanguageService()->sL('LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.sysLogErrors.chart.dataSet.0'),
                    'backgroundColor' => $this->chartColors[0],
                    'border' => 0,
                    'data' => $data
                ]
            ]
        ];
    }

    protected function getNumberOfErrorsInPeriod(int $start, int $end): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_log');
        return (int)$queryBuilder
            ->select('*')
            ->from('sys_log')
            ->where(
                $queryBuilder->expr()->eq('type', 5),
                $queryBuilder->expr()->gte('tstamp', $start),
                $queryBuilder->expr()->lte('tstamp', $end)
            )
            ->execute()
            ->rowCount();
    }

    protected function calculateDataForLastDays(int $days): array
    {
        $data = [];
        for ($daysBefore=$days; $daysBefore--; $daysBefore>0) {
            $labels[] = date('d-m-Y', strtotime('-' . $daysBefore . ' day'));
            $startPeriod = strtotime('-' . $daysBefore . ' day 0:00:00');
            $endPeriod =  strtotime('-' . $daysBefore . ' day 23:59:59');

            $data[] = $this->getNumberOfErrorsInPeriod($startPeriod, $endPeriod);
        }
        return $data;
    }
}
