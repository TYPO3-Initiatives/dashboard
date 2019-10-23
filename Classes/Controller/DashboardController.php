<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Controller;

use FriendsOfTYPO3\Dashboard\Configuration\Widget;
use FriendsOfTYPO3\Dashboard\DashboardConfiguration;
use FriendsOfTYPO3\Dashboard\Widgets\WidgetInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;

class DashboardController extends AbstractController
{
    /**
     * @var ModuleTemplate
     */
    protected $moduleTemplate;

    /**
     * @var UriBuilder
     */
    protected $uriBuilder;

    /** @var ViewInterface */
    protected $view;

    /** @var DashboardConfiguration */
    protected $dashboardConfiguration;

    /**
     * @var array
     */
    protected $cssFiles = [];

    /**
     * @var array
     */
    protected $jsFiles = [];

    public function __construct(ModuleTemplate $moduleTemplate = null, UriBuilder $uriBuilder = null, DashboardConfiguration $dashboardConfiguration = null)
    {
        $this->moduleTemplate = $moduleTemplate ?? GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->uriBuilder = $uriBuilder ?? GeneralUtility::makeInstance(UriBuilder::class);
        $this->dashboardConfiguration = $dashboardConfiguration ?? GeneralUtility::makeInstance(DashboardConfiguration::class);
    }

    /**
     * Main entry method: Dispatch to other actions - those method names that end with "Action".
     *
     * @param ServerRequestInterface $request the current request
     * @return ResponseInterface the response with the content
     */
    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $publicResourcesPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath('dashboard')) . 'Resources/Public/';
        $pageRenderer = $this->moduleTemplate->getPageRenderer();
        $pageRenderer->addRequireJsConfiguration(
            [
                'paths' => [
                    'dashboard' => $publicResourcesPath . 'JavaScript',
                    'muuri' => $publicResourcesPath . 'JavaScript/Dist/Muuri',
                ],
            ]
        );

        $pageRenderer->loadRequireJsModule('muuri');
        $pageRenderer->loadRequireJsModule('dashboard/Grid');
        $pageRenderer->loadRequireJsModule('dashboard/WidgetContentCollector');
        $pageRenderer->loadRequireJsModule('dashboard/WidgetSelector');
        $pageRenderer->loadRequireJsModule('dashboard/WidgetRemover');
        $pageRenderer->addCssFile($publicResourcesPath . 'CSS/dashboard.min.css');

        $action = $request->getQueryParams()['action'] ?? $request->getParsedBody()['action'] ?? 'main';
        $this->initializeView($action);

        $result = call_user_func_array([$this, $action . 'Action'], [$request]);
        if ($result instanceof ResponseInterface) {
            return $result;
        }

        foreach ($this->cssFiles as $cssFile) {
            $pageRenderer->addCssFile($cssFile);
        }

        foreach ($this->jsFiles as $key => $jsFile) {
            $pageRenderer->addRequireJsConfiguration([
                'paths' => [
                    $key => $jsFile
                ]
            ]);

            $pageRenderer->loadRequireJsModule($key);
        }

        $this->moduleTemplate->setContent($this->view->render());
        return new HtmlResponse($this->moduleTemplate->renderContent());
    }

    public function mainAction(ServerRequestInterface $request): void
    {
        $widgets = $this->getWidgetsForCurrentUser();
        $availableWidgets = [];
        foreach ($this->dashboardConfiguration->getWidgets() as $availableWidgetConfiguration) {
            $availableWidgets[$availableWidgetConfiguration->getIdentifier()] = GeneralUtility::makeInstance($availableWidgetConfiguration->getClassname());
        }
        $this->getJavascriptForWidgets($availableWidgets);
        $this->getCssForWidgets($availableWidgets);

        $this->view->assign('widgets', $widgets);
        $this->view->assign('availableWidgets', $availableWidgets);
        $this->view->assign('availableDashboards', $this->dashboardConfiguration->getDashboards());
        $this->view->assign('currentDashboard', $this->getCurrentDashboard());
        $parameters = [
            'widget' => '@widget',
            'action' => 'addWidget'
        ];
        $this->view->assign('addWidgetUri', (string)$this->uriBuilder->buildUriFromRoute('dashboard', $parameters));
    }

    /**
     * @param Widget[] $widgets
     * @throws \Exception
     */
    protected function getJavascriptForWidgets(array $widgets): void
    {
        foreach ($widgets as $widget) {
            foreach ($widget->getJsFiles() as $key => $jsFile) {
                if (!in_array($jsFile, $this->jsFiles, true)) {
                    $this->jsFiles[$key] = $jsFile;
                }
            }
        }
    }

    /**
     * @param Widget[] $widgets
     * @throws \Exception
     */
    protected function getCssForWidgets(array $widgets): void
    {
        foreach ($widgets as $widget) {
            foreach ($widget->getCssFiles() as $cssFile) {
                if (!in_array($cssFile, $this->cssFiles, true)) {
                    $this->cssFiles[] = $cssFile;
                }
            }
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function setActiveDashboardAction(ServerRequestInterface $request): ResponseInterface
    {
        //TODO: Save currentDashboard to user settings
        $this->getBackendUser()->pushModuleData('web_dashboard/current_dashboard/', $request->getQueryParams()['currentDashboard']);

        $route = $this->uriBuilder->buildUriFromRoute('dashboard', ['action' => 'main']);
        return new RedirectResponse($route);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function removeWidgetAction(ServerRequestInterface $request): ResponseInterface
    {
        $parameters = $request->getQueryParams();

        $widgets = $this->getBackendUser()->getModuleData('web_dashboard/dashboard/' . $this->getCurrentDashboard() . '/widgets');

        if (array_key_exists($parameters['widgetHash'], $widgets)) {
            unset($widgets[$parameters['widgetHash']]);
            $this->getBackendUser()->pushModuleData('web_dashboard/dashboard/' . $this->getCurrentDashboard() . '/widgets', $widgets);
        }

        $route = $this->uriBuilder->buildUriFromRoute('dashboard', ['action' => 'main']);
        return new RedirectResponse($route);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function addWidgetAction(ServerRequestInterface $request): ResponseInterface
    {
        $parameters = $request->getQueryParams();

        if ($parameters['widget']) {
            $widgets = $this->getBackendUser()->getModuleData('web_dashboard/dashboard/' . $this->getCurrentDashboard() . '/widgets');

            $key = sha1($parameters['widget'] . '-' . time());
            $widgets[$key] = $this->prepareWidgetElement($parameters['widget']);

            $this->getBackendUser()->pushModuleData('web_dashboard/dashboard/' . $this->getCurrentDashboard() . '/widgets', $widgets);
        }

        $route = $this->uriBuilder->buildUriFromRoute('dashboard', ['action' => 'main']);
        return new RedirectResponse($route);
    }

    /**
     * Sets up the Fluid View.
     *
     * @param string $templateName
     */
    protected function initializeView(string $templateName): void
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplate($templateName);
        $this->view->setTemplateRootPaths(['EXT:dashboard/Resources/Private/Templates/Dashboard']);
        $this->view->setPartialRootPaths(['EXT:dashboard/Resources/Private/Partials']);
        $this->view->setLayoutRootPaths(['EXT:dashboard/Resources/Private/Layouts']);

        $this->moduleTemplate->getDocHeaderComponent()->disable();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getWidgetsForCurrentUser(): array
    {
        $widgets = [];

        $tmpWidgets = $this->getBackendUser()->getModuleData('web_dashboard/dashboard/' . $this->getCurrentDashboard() . '/widgets');
        if (!empty($tmpWidgets)) {
            foreach ($tmpWidgets as $hash => $tmpWidget) {
                $widgets[$hash] = $this->prepareWidgetElement($tmpWidget['key'], $tmpWidget['config']);
            }
        }

        return $widgets;
    }

    /**
     * @param $widgetKey
     * @param array $config
     * @return array
     * @throws \Exception
     */
    public function prepareWidgetElement($widgetKey, $config = []): array
    {
        $widgetConfiguration = $this->dashboardConfiguration->getWidgets()[$widgetKey];
        if ($widgetConfiguration instanceof Widget) {
            $widgetObject = GeneralUtility::makeInstance($widgetConfiguration->getClassname());
            if ($widgetObject instanceof WidgetInterface) {
                return [
                    'key' => $widgetKey,
                    'height' => $widgetObject->getHeight(),
                    'width' => $widgetObject->getWidth(),
                    'title' => $widgetObject->getTitle(),
                    'additionalClasses' => $widgetObject->getAdditionalClasses(),
                    'config' => $config
                ];
            }
        }

        return [];
    }
}
