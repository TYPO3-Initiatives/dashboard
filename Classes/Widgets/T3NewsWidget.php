<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

class T3NewsWidget extends AbstractRssWidget
{
    protected $rssFile = 'https://typo3.org/?type=100';
    protected $lifeTime = 43200; // 12 hours cache
    protected $title = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.t3news.title';
    protected $description = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.t3news.description';
    protected $iconIdentifier = 'dashboard-typo3';
}
