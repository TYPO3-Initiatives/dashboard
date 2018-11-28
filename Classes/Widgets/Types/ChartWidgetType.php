<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Widgets\Types;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class ChartWidgetType extends AbstractWidgetType
{
    protected $jsSelector = 't3js-dashboard-widget-chartdata-collector';

    public function renderHTML(array $settings = []): string
    {
        $templateView = GeneralUtility::makeInstance(StandaloneView::class);
        $templateView->setTemplatePathAndFilename(
            GeneralUtility::getFileAbsFileName('EXT:dashboard/Resources/Private/Templates/Widgets/ChartWidget.html')
        );

        $templateView->assign('settings', $settings);
        $templateView->assign('config', $this->config);

        return $templateView->render();
    }
}
