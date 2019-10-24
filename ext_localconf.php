<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(function () {
    if (TYPO3_MODE === 'BE') {
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Imaging\IconRegistry::class
        );
        $icons = [
            'dashboard-action-dragdrop' => 'dashboard-action-dragdrop.svg',
            'dashboard-action-close' => 'dashboard-action-close.svg',
            'dashboard-admin' => 'dashboard-admin.svg',
            'dashboard-bars' => 'dashboard-bars.svg',
            'dashboard-chartbars' => 'dashboard-chartbars.svg',
            'dashboard-chart' => 'dashboard-chart.svg',
            'dashboard-chartline' => 'dashboard-chartline.svg',
            'dashboard-cta' => 'dashboard-cta.svg',
            'dashboard-dashboard' => 'dashboard-dashboard.svg',
            'dashboard-hashtag' => 'dashboard-hashtag.svg',
            'dashboard-pie' => 'dashboard-pie.svg',
            'dashboard-rss' => 'dashboard-rss.svg',
            'dashboard-signin' => 'dashboard-signin.svg',
            'dashboard-typo3' => 'dashboard-typo3.svg',
            'dashboard-user' => 'dashboard-user.svg',
            'mimetypes-x-sys_dashboard' => 'mimetypes-x-sys_dashboard.svg',
        ];
        foreach ($icons as $iconIdentifier => $iconFile) {
            $iconRegistry->registerIcon(
                $iconIdentifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                ['source' => 'EXT:dashboard/Resources/Public/Icons/' . $iconFile]
            );
        }
    }
});
