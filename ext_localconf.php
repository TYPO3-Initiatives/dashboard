<?php
defined('TYPO3_MODE') or die();

$widgetRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\FriendsOfTYPO3\Dashboard\Registry\WidgetRegistry::class);
$widgetRegistry->registerWidget('numberOfBackendUsers', \FriendsOfTYPO3\Dashboard\Widgets\NumberOfBackendUsersWidget::class);
$widgetRegistry->registerWidget('numberOfAdminBackendUsers', \FriendsOfTYPO3\Dashboard\Widgets\NumberOfAdminBackendUsersWidget::class);
$widgetRegistry->registerWidget('lastLogins', \FriendsOfTYPO3\Dashboard\Widgets\LastLoginsWidget::class);
$widgetRegistry->registerWidget('pagesWithoutDescription', \FriendsOfTYPO3\Dashboard\Widgets\PagesWithoutDescriptionWidget::class);
$widgetRegistry->registerWidget('t3News', \FriendsOfTYPO3\Dashboard\Widgets\T3NewsWidget::class);

$dashboardRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\FriendsOfTYPO3\Dashboard\Registry\DashboardRegistry::class);
$dashboardRegistry->registerDashboard('default', 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:dashboard.default');

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);
$iconRegistry->registerIcon(
    'dragdrop', // Icon-Identifier, z.B. tx-myext-action-preview
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/grip-vertical.svg']
);
