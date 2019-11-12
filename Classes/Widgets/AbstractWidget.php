<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\Interfaces\WidgetInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * The AbstractWidget class is the basic widget class for all widgets
 * Is it possible to extends this class for own widgets, but EXT:dashboard provide
 * also some more special types of widgets. For more details, please check:
 * @see AbstractChartWidget
 * @see AbstractCtaButtonWidget
 * @see AbstractListWidget
 * @see AbstractNumberWidget
 * @see AbstractRssWidget
 * More information can be found in the documentation.
 * @TODO: Add link to documentation
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
     * @var string
     */
    protected $templateName = 'Widget';

    /**
     * @var string
     */
    protected $extensionKey = 'dashboard';

    /**
     * @var ViewInterface
     */
    protected $view;

    protected $additionalClasses = '';

    public function __construct()
    {
        $this->initializeView();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIconIdentifier(): string
    {
        return $this->iconIdentifier;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function renderWidgetContent(): string
    {
        $this->view->assign('title', $this->title);
        return $this->view->render();
    }

    public function getAdditionalClasses(): string
    {
        return $this->additionalClasses;
    }

    protected function initializeView(): void
    {
        $this->view = GeneralUtility::makeInstance(StandaloneView::class);
        $this->view->setTemplate('Widget/' . $this->templateName);
        $this->view->getRenderingContext()->getTemplatePaths()->fillDefaultsByPackageName('dashboard');
        if ($this->extensionKey !== 'dashboard') {
            $this->view->getRenderingContext()->getTemplatePaths()->fillDefaultsByPackageName($this->extensionKey);
        }
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
