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
            'dragdrop' => 'Drag.svg',
            'timesCircle' => 'Times-circle.svg',
            'dashboard-admin' => 'AdminUser.svg',
            'dashboard-user' => 'User.svg',
            'dashboard-hashtag' => 'Hashtag.svg',
            'dashboard-bars' => 'Bars.svg',
            'dashboard-signin' => 'SignIn.svg',
            'dashboard-chart' => 'Chart.svg',
            'dashboard-chartline' => 'ChartLine.svg',
            'dashboard-rss' => 'Rss.svg',
            'dashboard-typo3' => 'TYPO3.svg',
            'dashboard-pie' => 'Pie.svg',
            'dashboard-cta' => 'Pointer.svg',
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
