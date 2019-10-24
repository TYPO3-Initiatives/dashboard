<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Controller;

use FriendsOfTYPO3\Dashboard\Configuration\Widget;
use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use FriendsOfTYPO3\Dashboard\Dashboards\DashboardRepository;
use FriendsOfTYPO3\Dashboard\Widgets\WidgetInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WidgetAjaxController extends AbstractController
{
    /**
     * @var DashboardConfiguration
     */
    protected $dashboardConfiguration;

    /**
     * @var DashboardRepository
     */
    protected $dashboardRepository;

    public function __construct(DashboardConfiguration $dashboardConfiguration = null, DashboardRepository $dashboardRepository = null)
    {
        $this->dashboardConfiguration = $dashboardConfiguration ?? GeneralUtility::makeInstance(DashboardConfiguration::class);
        $this->dashboardRepository = $dashboardRepository ?? GeneralUtility::makeInstance(DashboardRepository::class);
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

        $data = [];
        if ($widgetConfiguration instanceof Widget) {
            $widgetObject = GeneralUtility::makeInstance($widgetConfiguration->getClassname());
            if ($widgetObject instanceof WidgetInterface) {
                $data = [
                    'widget' => $queryParams['widget'],
                    'content' => $widgetObject->renderWidgetContent(),
                    'eventdata' => $widgetObject->getEventData()
                ];
            }
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
            $widgets[$widget[2]] = ['key' => $widget[0], 'config' => json_decode($widget[1], false)];
        }
        $dashboard = $this->dashboardRepository->getDashboardByIdentifier($this->getCurrentDashboard());
        $this->dashboardRepository->updateWidgets($dashboard, $widgets);
        return new JsonResponse(['status' => 'saved']);
    }
}
