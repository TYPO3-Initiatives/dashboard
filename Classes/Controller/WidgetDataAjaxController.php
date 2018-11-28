<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Controller;

use Haassie\Dashboard\WidgetDataProviders\WidgetDataProviderInterface;
use Haassie\Dashboard\Widgets\WidgetRegistry;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class WidgetDataAjaxController
{
    /**
     * @var WidgetRegistry
     */
    protected $widgetRegistry;

    public function __construct(WidgetRegistry $WidgetRegistry = null)
    {
        $this->widgetRegistry = $WidgetRegistry ?? GeneralUtility::makeInstance(WidgetRegistry::class);
    }

    public function getData(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $result = [];

        $queryParams = $request->getQueryParams();
        $result['widget'] = $queryParams['widget'];

        $widgetConfig = $this->widgetRegistry->getWidget($result['widget']);
        /** @var WidgetDataProviderInterface $widgetRenderObject */
        $widgetRenderObject = GeneralUtility::makeInstance($widgetConfig['dataProvider'], $widgetConfig);

        $result['data'] = $widgetRenderObject->getData();

        $response->getBody()->write(json_encode($result));
        return $response;
    }
}
