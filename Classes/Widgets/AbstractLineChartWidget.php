<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

/**
 * Class AbstractLineChartWidget
 * @package FriendsOfTYPO3\Dashboard\Widgets
 */
abstract class AbstractLineChartWidget extends AbstractChartWidget
{
    /**
     * @var string
     */
    protected $templateName = 'LineChartWidget';
}
