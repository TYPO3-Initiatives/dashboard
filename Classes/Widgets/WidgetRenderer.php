<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Widgets;

use Haassie\Dashboard\WidgetDataProviders\WidgetDataProviderInterface;
use Haassie\Dashboard\Widgets\Types\WidgetTypeInterface;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WidgetRenderer
{
    /**
     * @var WidgetRegistry
     */
    protected $widgetRegistry;

    public function __construct(WidgetRegistry $WidgetRegistry = null)
    {
        $this->widgetRegistry = $WidgetRegistry ?? GeneralUtility::makeInstance(WidgetRegistry::class);
    }

    /**
     * @param string $key
     * @param array $settings
     * @return array
     */
    public function renderWidget($key, $settings = []): array
    {
        $widgetConfig = $this->widgetRegistry->getWidget($key);
        $widgetRenderObject = GeneralUtility::makeInstance($widgetConfig['renderer'], $widgetConfig);
        if ($widgetRenderObject instanceof WidgetTypeInterface) {
            return [
                'jsSelector' => $widgetRenderObject->getJsSelector(),
                'label' => $widgetConfig['label'],
                'html' => $widgetRenderObject->renderHTML($settings)
            ];
        } else {
            throw new Exception('Wrong data provider');
        }
    }
}
