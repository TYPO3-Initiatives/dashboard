<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Registry;

use FriendsOfTYPO3\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WidgetRegistry implements SingletonInterface
{
    /**
     * @var array
     */
    protected $widgets = [];

    /**
     * @param string $key
     * @param string $widgetClass
     */
    public function registerWidget(string $key, string $widgetClass): void
    {
        $widgetObject = GeneralUtility::makeInstance($widgetClass);
        if (!$widgetObject instanceof WidgetInterface) {
            throw new \RuntimeException($widgetClass . ' is not an instance of ' . WidgetInterface::class);
        }

        $this->widgets[$key] = $widgetObject;
    }

    /**
     * @return array
     */
    public function getWidgets(): array
    {
        return $this->widgets;
    }

    /**
     * @param $key
     * @return WidgetInterface
     * @throws \Exception
     */
    public function getWidgetObject(string $key): WidgetInterface
    {
        if (array_key_exists($key, $this->widgets) && $this->widgets[$key] instanceof WidgetInterface) {
            return $this->widgets[$key];
        }

        throw new \Exception('No valid widget found with this key');
    }
}
