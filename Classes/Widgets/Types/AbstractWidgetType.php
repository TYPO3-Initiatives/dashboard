<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Widgets\Types;

abstract class AbstractWidgetType implements WidgetTypeInterface
{
    /**
     * @var array
     */
    protected $config = [];

    protected $jsSelector = 't3js-dashboard-widget-data-collector';

    public function getJsSelector(): string
    {
        return $this->jsSelector;
    }

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
