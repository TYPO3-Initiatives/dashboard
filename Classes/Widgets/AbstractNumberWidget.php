<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

abstract class AbstractNumberWidget extends AbstractWidget
{
    protected $number;

    protected $templateName = 'NumberWidget';

    protected $iconIdentifier = 'dashboard-hashtag';

    protected $icon;

    public function __construct()
    {
        $this->height = 2;
        $this->width = 2;

        $publicResourcesPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath('dashboard')) . 'Resources/Public/';
        $this->cssFiles[] = $publicResourcesPath . 'CSS/numberWidget.min.css';
    }

    /**
     * @return string
     */
    public function renderWidgetContent(): string
    {
        $this->prepareData();
        $this->initializeView();

        $iconFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Imaging\IconFactory::class
        );

        $this->view->assign('icon', $this->icon);
        $this->view->assign('title', $this->title);
        $this->view->assign('number', $this->number);

        return $this->view->render();
    }
}
