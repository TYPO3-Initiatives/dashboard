<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

/**
 * Class SysLogErrorsWidget
 * @package FriendsOfTYPO3\Dashboard\Widgets
 */
class SysLogErrorsWidget extends AbstractLineChartWidget
{
    /**
     * @var string
     */
    protected $title = 'Syslog Errors';

    /**
     * @var int
     */
    protected $width = 2;

    /**
     * @var int
     */
    protected $height = 2;

    public function prepareData(): void
    {
        // TODO: Implement prepareData() method.
    }
}
