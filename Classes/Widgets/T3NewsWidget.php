<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

class T3NewsWidget extends AbstractRssWidget
{
    protected $rssFile = 'https://typo3.org/?type=100';
    protected $title = 'TYPO3 News';
    protected $iconIdentifier = 'dashboard-typo3';
}
