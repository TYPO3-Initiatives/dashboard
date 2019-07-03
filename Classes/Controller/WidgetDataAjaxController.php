<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Controller;

use Haassie\Dashboard\WidgetDataProviders\WidgetDataProviderInterface;
use Haassie\Dashboard\Widgets\WidgetRegistry;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WidgetDataAjaxController
{
    /**
     * @var WidgetRegistry
     */
    protected $widgetRegistry;

    /**
     * WidgetDataAjaxController constructor.
     * @param WidgetRegistry|null $WidgetRegistry
     */
    public function __construct(WidgetRegistry $WidgetRegistry = null)
    {
        $this->widgetRegistry = $WidgetRegistry ?? GeneralUtility::makeInstance(WidgetRegistry::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \TYPO3\CMS\Core\Exception
     */
    public function getData(ServerRequestInterface $request): ResponseInterface
    {
        $result = [];

        $queryParams = $request->getQueryParams();
        $result['widget'] = $queryParams['widget'];

        $widgetConfig = $this->widgetRegistry->getWidget($result['widget']);
        /** @var WidgetDataProviderInterface $widgetRenderObject */
        $widgetRenderObject = GeneralUtility::makeInstance($widgetConfig['dataProvider'], $widgetConfig);

        $result['data'] = $widgetRenderObject->getData();

        return new JsonResponse($result);
    }
}
