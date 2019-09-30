<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3Fluid\Fluid\View\ViewInterface;

/**
 * Class AbstractWidget
 */
abstract class AbstractWidget implements WidgetInterface
{
    protected $title;
    protected $height;
    protected $width;

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
        $this->prepareData();
        $this->initializeView();

        $this->view->assign('title', $this->title);

        return $this->view->render();
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
}
