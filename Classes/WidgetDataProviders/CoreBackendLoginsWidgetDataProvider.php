<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CoreBackendLoginsWidgetDataProvider extends AbstractChartWidgetDataProvider
{
    protected function initializeData(): void
    {
        $numberOfDays = 30;
        $labels = [];
        $data = [];

        $date = new \DateTime();
        $dateInterval = new \DateInterval('P1D');
        $dateInterval->invert = 1;

        for ($i=$numberOfDays; $i > 0; $i--) {
            $date->add($dateInterval);

            $labels[] = $date->format('d-m-Y');
            $data[] = $this->getLoginsForDate($date);
        }
        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Number of logins',
                    'data' => $data,
                    'fill' => false,
                    'borderColor' => 'rgb(70,130,180)',
                    'lineTension' => 0.1
                ]
            ]
        ];

        $this->setProperty('chartType', 'line');
        $this->setProperty('chartHeight', 100);
        $this->setProperty('chartData', $data);
    }

    /**
     * @param \DateTime $date
     * @return int
     */
    protected function getLoginsForDate(\DateTime $date): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_log');

        $dateStartEndTime = $this->getStartStopTimeOfDateTimeObject($date);

        $numberOfLogins = $queryBuilder
            ->count('*')
            ->from('sys_log')
            ->where(
                $queryBuilder->expr()->eq(
                    'type',
                    $queryBuilder->createNamedParameter(255, \PDO::PARAM_INT)
                ),
                $queryBuilder->expr()->eq(
                    'action',
                    $queryBuilder->createNamedParameter(1, \PDO::PARAM_INT)
                ),
                $queryBuilder->expr()->gte(
                    'tstamp',
                    $queryBuilder->createNamedParameter($dateStartEndTime['start'], \PDO::PARAM_INT)
                ),
                $queryBuilder->expr()->lte(
                    'tstamp',
                    $queryBuilder->createNamedParameter($dateStartEndTime['end'], \PDO::PARAM_INT)
                )
            )
            ->execute()->fetchColumn();

        return (int)$numberOfLogins;
    }

    /**
     * @param \DateTime $date
     * @return array
     */
    protected function getStartStopTimeOfDateTimeObject(\DateTime $date): array
    {
        $date->setTime(0, 0, 0);
        $startTime = $date->getTimestamp();

        $date->setTime(23, 59, 59);
        $endTime = $date->getTimestamp();

        return ['start' => (int)$startTime, 'end' => (int)$endTime];
    }
}
