<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Controller;

use FriendsOfTYPO3\Dashboard\Registry\DashboardRegistry;
use FriendsOfTYPO3\Dashboard\Registry\WidgetRegistry;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class DashboardController
{
    /**
     * @var ModuleTemplate
     */
    protected $moduleTemplate;

    /**
     * @var WidgetRegistry
     */
    protected $widgetRegistry;

    /**
     * @var UriBuilder
     */
    protected $uriBuilder;

    /** @var ViewInterface */
    protected $view;

    /** @var DashboardRegistry */
    protected $dashboardRegistry;

    /**
     * @var array
     */
    protected $cssFiles = [];

    public function __construct()
    {
        $this->moduleTemplate = GeneralUtility::makeInstance(ModuleTemplate::class);
        $this->widgetRegistry = GeneralUtility::makeInstance(WidgetRegistry::class);
        $this->uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $this->dashboardRegistry = GeneralUtility::makeInstance(DashboardRegistry::class);
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

        $this->moduleTemplate->getPageRenderer()->addRequireJsConfiguration(
            array(
                'paths' => array(
                    'dashboard' => $publicResourcesPath . 'JavaScript',
                    'muuri' => $publicResourcesPath . 'JavaScript/Dist/Muuri',
                ),
            )
        );

        $this->moduleTemplate->getPageRenderer()->loadRequireJsModule('muuri');
        $this->moduleTemplate->getPageRenderer()->loadRequireJsModule('dashboard/Grid');
        $this->moduleTemplate->getPageRenderer()->loadRequireJsModule('dashboard/WidgetContentCollector');
        $this->moduleTemplate->getPageRenderer()->loadRequireJsModule('dashboard/WidgetSelector');
        $this->moduleTemplate->getPageRenderer()->loadRequireJsModule('dashboard/WidgetRemover');
        $this->moduleTemplate->getPageRenderer()->addCssFile($publicResourcesPath . 'CSS/Dashboard.css');

        $action = $request->getQueryParams()['action'] ?? $request->getParsedBody()['action'] ?? 'main';
        $this->initializeView($action);

        $result = call_user_func_array([$this, $action . 'Action'], [$request]);
        if ($result instanceof ResponseInterface) {
            return $result;
        }

        foreach ($this->cssFiles as $cssFile) {
            $this->moduleTemplate->getPageRenderer()->addCssFile($cssFile);
        }

        $this->moduleTemplate->setContent($this->view->render());
        return new HtmlResponse($this->moduleTemplate->renderContent());
    }

    public function mainAction(ServerRequestInterface $request): void
    {
        $widgets = $this->getWidgetsForCurrentUser();
        $availableWidget = $this->widgetRegistry->getWidgets();

        $this->view->assign('widgets', $widgets);
        $this->view->assign('availableWidgets', $availableWidget);
        $this->view->assign('availableDashboards', $this->dashboardRegistry->getDashboards());
        $this->view->assign('currentDashboard', $this->getCurrentDashboard());
        $parameters = [
            'widget' => '@widget',
            'action' => 'addWidget'
        ];
        $this->view->assign('addWidgetUri', (string)$this->uriBuilder->buildUriFromRoute('dashboard', $parameters));
    }

    public function setActiveDashboardAction(ServerRequestInterface $request): ResponseInterface
    {
        //TODO: Save currentDashboard to user settings
        $this->getBackendUser()->pushModuleData('web_dashboard/current_dashboard/', $request->getQueryParams()['currentDashboard']);

        $route = $this->uriBuilder->buildUriFromRoute('dashboard', ['action' => 'main']);
        return new RedirectResponse($route);

    }

    public function removeWidgetAction(ServerRequestInterface $request): ResponseInterface
    {
        $parameters = $request->getQueryParams();

        DebuggerUtility::var_dump($parameters);
    }

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

    protected function getWidgetsForCurrentUser(): array
    {
        $widgets = [];

        $tmpWidgets = $this->getBackendUser()->getModuleData('web_dashboard/dashboard/' . $this->getCurrentDashboard() . '/widgets');
        if (!empty($tmpWidgets)) {
            foreach ($tmpWidgets as $hash => $tmpWidget) {
                $widgets[$hash] = $this->prepareWidgetElement($tmpWidget['key'], $tmpWidget['config']);
            }
        } else {
            // TODO: default widgets when no user settings are found
            $defaultWidgets = ['numberOfBackendUsers', 'numberOfAdminBackendUsers', 'lastLogins'];
            foreach ($defaultWidgets as $defaultWidget) {
                $widgets[$this->getWidgetKey($defaultWidget)] = $this->prepareWidgetElement($defaultWidget);
            }

            $this->getBackendUser()->pushModuleData('web_dashboard/dashboard/' . $this->getCurrentDashboard() . '/widgets', $widgets);
        }

        return $widgets;
    }


    public function prepareWidgetElement($widgetKey, $config = []): array
    {
        $widgetObject = $this->widgetRegistry->getWidgetObject($widgetKey);

        foreach($widgetObject->getCssFiles() as $cssFile) {
            if (!in_array($cssFile, $this->cssFiles, true)) {
                $this->cssFiles[] = $cssFile;
            }
        }

        return [
            'key' => $widgetKey,
            'height' => $widgetObject->getHeight(),
            'width' => $widgetObject->getWidth(),
            'title' => $widgetObject->getTitle(),
            'config' => $config
        ];
    }

    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
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
