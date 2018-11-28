<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

abstract class AbstractTextWidgetDataProvider implements WidgetDataProviderInterface
{
    protected $data = [
        'preheader' => '',
        'header' => '',
        'subheader' => '',
        'text' => ''
    ];

    protected function initializeData(): void
    {
    }

    protected function setProperty(string $property, string $value): void
    {
        $this->data[$property] = $value;
    }

    public function getData(): array
    {
        $this->initializeData();

        return $this->data;
    }
}
