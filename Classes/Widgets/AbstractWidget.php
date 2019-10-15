<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Class AbstractWidget
 */
abstract class AbstractWidget implements WidgetInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var int
     */
    protected $height = 2;

    /**
     * @var int
     */
    protected $width = 2;

    /**
     * @var string
     */
    protected $iconIdentifier = '';

    /**
     * @var array
     */
    protected $cssFiles = [];

    /**
     * @var array
     */
    protected $jsFiles = [];

    /**
     * @var string
     */
    protected $templateName = 'Widget';

    /**
     * @var ViewInterface
     */
    protected $view;

    protected $additionalClasses = '';

    /**
     * @var string
     */
    protected $publicResourcesPath;

    /**
     * @var array
     */
    protected $eventData = [];

    protected $languagePrefix = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:';

    /**
     * AbstractWidget constructor.
     */
    public function __construct()
    {
        $this->publicResourcesPath =
            PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath('dashboard')) . 'Resources/Public/';
    }

    /**
     * Sets up the Fluid View.
     *
     * @param string $templateName
     */
    protected function initializeView(): void
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplate($this->templateName);
        $this->view->setTemplateRootPaths(['EXT:dashboard/Resources/Private/Templates/Widgets']);
        $this->view->setPartialRootPaths(['EXT:dashboard/Resources/Private/Partials/Widgets']);
        $this->view->setLayoutRootPaths(['EXT:dashboard/Resources/Private/Layouts/Widgets']);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getIconIdentifier(): string
    {
        return $this->iconIdentifier;
    }
    /**
     * @return int  Returns height of widget in rows (1-4)
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int  Returns width of widget in columns (1-4)
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function renderWidgetContent(): string
    {
        $this->initializeView();
        $this->prepareData();

        $this->view->assign('title', $this->title);

        return $this->view->render();
    }

    /**
     * @return array
     */
    public function getEventData(): array
    {
        return $this->eventData;
    }

    /**
     * @return array
     */
    public function getCssFiles(): array
    {
        return $this->cssFiles;
    }

    /**
     * @return array
     */
    public function getJsFiles(): array
    {
        return $this->jsFiles;
    }

    public function getAdditionalClasses(): string
    {
        return $this->additionalClasses;
    }

    /**
     * Returns the LanguageService
     *
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}
