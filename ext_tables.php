<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
    'web',
    'dashboard',
    'top',
    '',
    [
        'routeTarget' => \FriendsOfTYPO3\Dashboard\Controller\DashboardController::class . '::handleRequest',
        'access' => 'user,group',
        'name' => 'web_dashboard',
        'icon' => 'EXT:dashboard/Resources/Public/Icons/module-dashboard.svg',
        'navigationComponentId' => '',
        'inheritNavigationComponentFromMainModule' => false,
        'labels' => 'LLL:EXT:dashboard/Resources/Private/Language/locallang_mod.xlf'
    ]
);
