<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Controller;

use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use FriendsOfTYPO3\Dashboard\Widgets\WidgetInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WidgetAjaxController
{
    /**
     * @var DashboardConfiguration
     */
    protected $dashboardConfiguration;

    public function __construct(DashboardConfiguration $dashboardConfiguration = null)
    {
        $this->dashboardConfiguration = $dashboardConfiguration ?? GeneralUtility::makeInstance(DashboardConfiguration::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function getContent(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $widgetConfiguration = $this->dashboardConfiguration->getWidgets()[$queryParams['widget']];

        $widgetObject = GeneralUtility::makeInstance($widgetConfiguration->getClassname());
        $data = [];
        if ($widgetObject instanceof WidgetInterface) {
            $data = [
                'widget' => $queryParams['widget'],
                'content' => $widgetObject->renderWidgetContent(),
                'eventdata' => $widgetObject->getEventData()
            ];
        }

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
