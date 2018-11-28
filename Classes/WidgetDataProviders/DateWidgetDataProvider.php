<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

class DateWidgetDataProvider implements WidgetDataProviderInterface
{
    public function getData(): array
    {
        return [
            'preheader' => strftime('%A'),
            'header' => strftime('%e %B %Y'),
        ];
    }

}