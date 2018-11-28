<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

interface WidgetDataProviderInterface
{
    public function getData(): array;
}