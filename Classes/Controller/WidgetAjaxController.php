<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Controller;

use FriendsOfTYPO3\Dashboard\Registry\WidgetRegistry;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
            $widgets[$widget[2]] = ['key' => $widget[0], 'config' => json_decode($widget[1])];
        }

        $this->getBackendUser()->pushModuleData('web_dashboard/dashboard/' . $this->getCurrentDashboard() . '/widgets', $widgets);
        return new JsonResponse(['status' => 'saved']);
    }

    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * @return string
     */
    protected function getCurrentDashboard(): string
    {
        return $this->getBackendUser()->getModuleData('web_dashboard/current_dashboard/') ?: 'default';
    }

    /**
     * @param string $key
     * @param array $config
     * @return string
     */
    protected function getWidgetKey(string $key, array $config = [])
    {
        return sha1(implode('|', [$key, serialize($config)]));
    }
}
