<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Widgets;

use Haassie\Dashboard\Widgets\Types\ChartWidgetType;
use Haassie\Dashboard\Widgets\Types\TextWidgetType;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\SingletonInterface;

class WidgetRegistry implements SingletonInterface
{
    /**
     * @var array
     */
    protected $widgets = [];

    protected $availableTypes = [
        'text' => TextWidgetType::class,
        'chart' => ChartWidgetType::class
    ];

    /**
     * @param string $key Unique identifier of the widget
     * @param string $label Label of the widget which will be shown in the dashboard
     * @param string $type Type of the widget. Only types that are defined in $this->availableTypes are allowed
     * @param string $dataProvider Class which contains method getData to provide data to widget
     * @throws \Exception
     */
    public function registerWidget($key, $label, $type, $dataProvider): void
    {
        if (!array_key_exists($type, $this->availableTypes)) {
            throw new Exception('Unknown widget type ' . $type . ' detected');
        }

        if (array_key_exists($key, $this->widgets)) {
            throw new Exception('Widget ' . $key . ' already existed');
        }

        $this->widgets[$key] = [
            'label' => $label,
            'renderer' => $this->availableTypes[$type],
            'dataProvider' => $dataProvider
        ];
    }

    /**
     * @return array
     */
    public function getWidgets(): array
    {
        return $this->widgets;
    }

    /**
     * @param string $key
     * @return array
     * @throws Exception
     */
    public function getWidget($key): array
    {
        if (!array_key_exists($key, $this->widgets)) {
            throw new Exception('No widget with key ' . $key . ' registered');
        }

        return $this->widgets[$key];
    }
}
