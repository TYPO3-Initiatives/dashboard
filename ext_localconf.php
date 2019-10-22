<?php
defined('TYPO3_MODE') or die();

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);
$iconRegistry->registerIcon(
    'dragdrop', // Icon-Identifier, z.B. tx-myext-action-preview
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/Drag.svg']
);
$iconRegistry->registerIcon(
    'timesCircle', // Icon-Identifier, z.B. tx-myext-action-preview
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/Times-circle.svg']
);
$iconRegistry->registerIcon(
    'dashboard-admin',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/AdminUser.svg']
);
$iconRegistry->registerIcon(
    'dashboard-user',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/User.svg']
);
$iconRegistry->registerIcon(
    'dashboard-hashtag',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/Hashtag.svg']
);
$iconRegistry->registerIcon(
    'dashboard-bars',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/Bars.svg']
);
$iconRegistry->registerIcon(
    'dashboard-signin',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/SignIn.svg']
);
$iconRegistry->registerIcon(
    'dashboard-chart',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/Chart.svg']
);
$iconRegistry->registerIcon(
    'dashboard-chartline',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/ChartLine.svg']
);
$iconRegistry->registerIcon(
    'dashboard-rss',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/Rss.svg']
);
$iconRegistry->registerIcon(
    'dashboard-typo3',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/TYPO3.svg']
);
$iconRegistry->registerIcon(
    'dashboard-pie',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/Pie.svg']
);
$iconRegistry->registerIcon(
    'dashboard-cta',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:dashboard/Resources/Public/Icons/Pointer.svg']
);
