<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'Haassie.Dashboard',
    'web',
    'dashboard',
    'top',
    [
        'Dashboard' => 'main,addWidget,removeWidget',
    ],
    [
        'access' => 'user,group',
        'icon' => 'EXT:dashboard/Resources/Public/Icons/module-dashboard.svg',
        'navigationComponentId' => '',
        'inheritNavigationComponentFromMainModule' => false,
        'labels' => 'LLL:EXT:dashboard/Resources/Private/Language/locallang_mod.xlf'
    ]
);

/** @var \Haassie\Dashboard\Widgets\WidgetRegistry $widgetRegistry */
$widgetRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\Haassie\Dashboard\Widgets\WidgetRegistry::class);
$widgetRegistry->registerWidget(
    'dashboard_date',
    'Today',
    'text',
    \Haassie\Dashboard\WidgetDataProviders\DateWidgetDataProvider::class
);
$widgetRegistry->registerWidget(
    'dashboard_pie',
    'Pie',
    'chart',
    \Haassie\Dashboard\WidgetDataProviders\PieChartWidgetDataProvider::class
);
$widgetRegistry->registerWidget(
    'dashboard_bar',
    'Bar',
    'chart',
    \Haassie\Dashboard\WidgetDataProviders\BarChartWidgetDataProvider::class
);
$widgetRegistry->registerWidget(
    'dashboard_line',
    'Line',
    'chart',
    \Haassie\Dashboard\WidgetDataProviders\LineChartWidgetDataProvider::class
);
