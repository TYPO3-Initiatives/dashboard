<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

class DateWidgetDataProvider extends AbstractTextWidgetDataProvider
{
    protected function initializeData(): void
    {
        $this->setProperty('preheader', strftime('%A'));
        $this->setProperty('header', strftime('%e %B %Y'));
    }
}
