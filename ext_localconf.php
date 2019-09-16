<?php
defined('TYPO3_MODE') or die();

$widgetRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\FriendsOfTYPO3\Dashboard\Registry\WidgetRegistry::class);
$widgetRegistry->registerWidget('numberOfBackendUsers', \FriendsOfTYPO3\Dashboard\Widgets\NumberOfBackendUsersWidget::class);
$widgetRegistry->registerWidget('numberOfAdminBackendUsers', \FriendsOfTYPO3\Dashboard\Widgets\NumberOfAdminBackendUsersWidget::class);
$widgetRegistry->registerWidget('lastLogins', \FriendsOfTYPO3\Dashboard\Widgets\LastLoginsWidget::class);
