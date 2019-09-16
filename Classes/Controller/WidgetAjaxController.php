<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Controller;

use FriendsOfTYPO3\Dashboard\Registry\WidgetRegistry;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WidgetAjaxController
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function getContent(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $widgetRegistry = GeneralUtility::makeInstance(WidgetRegistry::class);
        $widgetObject = $widgetRegistry->getWidgetObject($queryParams['widget']);
        $data = [];
        $data['widget'] = $queryParams['widget'];
        $data['content'] = $widgetObject->renderWidgetContent();

        return new JsonResponse($data);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function savePositions(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        $widgets = [];
        foreach ($body['widgets'] as $widget) {
            $widgets[] = ['key' => $widget[0], 'config' => json_decode($widget[1])];
        }

        $this->getBackendUser()->pushModuleData('web_dashboard/dashboard/', $widgets);
        return new JsonResponse(['status' => 'saved']);
    }

    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
