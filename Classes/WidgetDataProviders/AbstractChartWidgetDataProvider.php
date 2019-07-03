<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\WidgetDataProviders;

abstract class AbstractChartWidgetDataProvider implements WidgetDataProviderInterface
{
    protected $data = [
        'chartType' => 'pie',
        'chartWidth' => 200,
        'chartHeight' => 200,
        'chartData' => '',
        'chartDescription' => ''
    ];

    protected function initializeData(): void
    {
    }

    protected function setProperty(string $property, $value): void
    {
        $this->data[$property] = $value;
    }

    public function getData(): array
    {
        $this->initializeData();

        return $this->data;
    }
}
