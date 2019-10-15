<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

abstract class AbstractCtaButtonWidget extends AbstractWidget
{
    protected $link = 'https://www.typo3.org';
    protected $label = 'TYPO3';

    protected $iconIdentifier = 'dashboard-cta';

    /**
     * @var string
     */
    protected $templateName = 'CtaWidget';

    public function __construct()
    {
        AbstractWidget::__construct();

        $this->height = 1;

        $publicResourcesPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath('dashboard')) . 'Resources/Public/';
        $this->cssFiles[] = $publicResourcesPath . 'CSS/ctaWidget.min.css';
    }

    public function prepareData(): void
    {
       $this->view->assign('link', $this->link);
       $this->view->assign('label', $this->label);
    }
}
