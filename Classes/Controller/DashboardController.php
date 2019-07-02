<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Controller;

use Haassie\Dashboard\Utility\DashboardLayoutUtility;
use Haassie\Dashboard\Widgets\WidgetRegistry;
use Haassie\Dashboard\Widgets\WidgetRenderer;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class DashboardController extends ActionController
{
    /**
     * Backend Template Container.
     * Takes care of outer "docheader" and other stuff this module is embedded in.
     *
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * BackendTemplateContainer
     *
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * @var PageRenderer
     */
    protected $pageRenderer;

    /**
     * @var string
     */
    protected $currentDashboardLayout = 'default';

    protected function addShortcutButton(): void
    {
        /** @var ButtonBar $buttonBar */
        $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();
        $shortcutName = $this->getLanguageService()->sL(
            'LLL:EXT:dashboard/Resources/Private/Language/locallang_mod.xml:mlang_tabs_tab'
        );

        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setModuleName($this->request->getPluginName())
            ->setDisplayName($shortcutName);
        $buttonBar->addButton($shortcutButton);
    }

    protected function addDashboardSelector(): void
    {
        $dashboardSelector = $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->makeMenu();
        $dashboardSelector->setIdentifier('currentDashboard');
        $dashboardSelector->setLabel(
            $this->getLanguageService()->sL(
                'LLL:EXT:dashboard/Resources/Private/Language/locallang_mod.xml:dashboardSelector_label'
            )
        );

        $currentDashboardLayout = $this->getCurrentDashboardLayout();
        $availableLayouts = $this->getDashboardLayoutUtility()->getLayouts();

        foreach ($availableLayouts as $layoutKey => $layoutConfig) {
            $parameters = [
                'tx_dashboard_web_dashboarddashboard[currentDashboard]' => $layoutKey,
            ];

            $url = $this->getUriBuilder()->buildUriFromRoute('web_DashboardDashboard', $parameters);

            $menuItem = $dashboardSelector
                ->makeMenuItem()
                ->setTitle(
                    $this->getLanguageService()->sL($layoutConfig['label']) ?: $layoutKey
                )
                ->setHref($url);

            if ($currentDashboardLayout === $layoutKey) {
                $menuItem->setActive(true);
            }

            $dashboardSelector->addMenuItem($menuItem);
        }

        $this->view->getModuleTemplate()->getDocHeaderComponent()->getMenuRegistry()->addMenu($dashboardSelector);
    }

    protected function setModuleHeader()
    {
        $this->addDashboardSelector();
        $this->addShortcutButton();
    }

    /**
     * @param ViewInterface $view
     *
     * @return void
     */
    protected function initializeView(ViewInterface $view)
    {
        parent::initializeView($view);

        // Early return for actions without valid view like tcaCreateAction or tcaDeleteAction
        if (!($this->view instanceof BackendTemplateView)) {
            return;
        }

        $this->setModuleHeader();
    }

    public function initializeAction()
    {
        if (($savedDashboardLayout = $this->getBackendUser()->getModuleData('web_dashboard/currentDashboard')) !== null) {
            $this->currentDashboardLayout = $savedDashboardLayout;
        }

        if ($this->request->hasArgument('currentDashboard')
            && $this->request->getArgument('currentDashboard')) {
            $this->currentDashboardLayout = $this->request->getArgument('currentDashboard');
        }

        $this->getBackendUser()->pushModuleData('web_dashboard/currentDashboard', $this->currentDashboardLayout);

        if (!($this->pageRenderer instanceof PageRenderer)) {
            $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        }

        $publicResourcesPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath('dashboard')) . 'Resources/Public/';

        $this->pageRenderer->addCssFile(
            $publicResourcesPath . 'CSS/Style.css'
        );

        $this->pageRenderer->addRequireJsConfiguration(
            [
                'paths' => array(
                    'Dashboard' => $publicResourcesPath . 'JavaScript/'
                )
            ]
        );
    }

    public function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    public function mainAction(): void
    {
        $this->pageRenderer->loadRequireJsModule('Dashboard/Chart.min');
        $this->pageRenderer->loadRequireJsModule('Dashboard/WidgetSelector');
        $this->pageRenderer->loadRequireJsModule('Dashboard/WidgetCloser');
        $this->pageRenderer->loadRequireJsModule('Dashboard/WidgetDataCollector');
        $this->pageRenderer->loadRequireJsModule('Dashboard/WidgetChartDataCollector');

        $widgets = $this->getWidgets();

        $this->view->assign('currentDashboardLayout', $this->getCurrentDashboardLayout());
        $this->view->assign(
            'currentDashboardLayoutConfiguration',
            $this->getDashboardLayoutUtility()->getConfiguration(
                $this->getCurrentDashboardLayout()
            )
        );
        $this->view->assign('widgets', $widgets);
        $this->view->assign('availableWidgets', $this->getAvailableWidgets());
    }

    public function addWidgetAction(array $data = null): void
    {
        $selectedWidget = $data['widget'] ?? '';
        $selectedLocation = $data['location'] ?? '';

        if (!array_key_exists($selectedWidget, $this->getAvailableWidgets())) {
            throw new Exception('Invalid widget selected');
        }
        if (!$this->currentDashboardLayout) {
            throw new Exception('No dashboard selected');
        }

        //@todo add more checks before saving


        $widgets = $this->getBackendUser()->getModuleData('web_dashboard/dashboard/' . $this->currentDashboardLayout);
        $widgets[$selectedLocation] = ['widget' => $selectedWidget, 'settings' => []];
        $this->getBackendUser()->pushModuleData('web_dashboard/dashboard/' . $this->currentDashboardLayout, $widgets);

        $this->redirect('main');
    }

    public function removeWidgetAction(array $data = null): void
    {
        $selectedLocation = $data['location'] ?? '';

        if (!$this->currentDashboardLayout) {
            throw new Exception('No dashboard selected');
        }

        $widgets = $this->getBackendUser()->getModuleData('web_dashboard/dashboard/' . $this->currentDashboardLayout);
        unset($widgets[$selectedLocation]);
        $this->getBackendUser()->pushModuleData('web_dashboard/dashboard/' . $this->currentDashboardLayout, $widgets);

        $this->redirect('main');
    }

    protected function getWidgets(): array
    {
        $widgets = $this->getBackendUser()->getModuleData('web_dashboard/dashboard/' . $this->currentDashboardLayout) ?? [];

        $widgetRenderer = GeneralUtility::makeInstance(WidgetRenderer::class);

        foreach ($widgets as $location => &$config) {
            $config['render'] = $widgetRenderer->renderWidget($config['widget']);
        }

        return $widgets;
    }

    /**
     * @return array
     */
    protected function getAvailableWidgets(): array
    {
        $widgetRegistry = GeneralUtility::makeInstance(WidgetRegistry::class);
        return $widgetRegistry->getWidgets();
    }

    protected function getCurrentDashboardLayout(): string
    {
        return $this->currentDashboardLayout;
    }

    protected function getDashboardLayoutUtility(): DashboardLayoutUtility
    {
        return GeneralUtility::makeInstance(DashboardLayoutUtility::class);
    }

    protected function getUriBuilder(): UriBuilder
    {
        return GeneralUtility::makeInstance(UriBuilder::class);
    }

    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
