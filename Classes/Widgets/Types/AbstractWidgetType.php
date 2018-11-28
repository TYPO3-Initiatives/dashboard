<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Widgets\Types;

abstract class AbstractWidgetType implements WidgetTypeInterface
{
    /**
     * @var array
     */
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}