<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\Interfaces\AdditionalCssInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The AbstractRssWidget class is the basic widget class to display items from a RSS feed.
 * Is it possible to extends this class for own widgets.
 * In your class you have to set $this->rssFile with the URL to the feed.
 * More information can be found in the documentation.
 * @TODO: Add link to documentation
 */
abstract class AbstractRssWidget extends AbstractListWidget implements AdditionalCssInterface
{
    protected $rssFile = '';

    protected $iconIdentifier = 'dashboard-rss';

    protected $templateName = 'RssWidget';

    public function __construct()
    {
        AbstractListWidget::__construct();
        $this->width = 4;
        $this->height = 6;
        $this->loadRssFeed();
    }

    public function setRssFile(string $rssFile): void
    {
        $this->rssFile = $rssFile;
    }

    /**
     * This method returns an array with paths to required CSS files.
     * e.g. ['EXT:myext/Resources/Public/Css/my_widget.css']
     * @return array
     */
    public function getCssFiles(): array
    {
        return ['EXT:dashboard/Resources/Public/CSS/rssWidget.min.css'];
    }

    protected function loadRssFeed(): void
    {
        // @TODO: This method should use a cache for better performance
        /** @var \SimpleXMLElement $rssFeed */
        $rssFeed = simplexml_load_string(GeneralUtility::getUrl($this->rssFile));
        $itemCount = 0;
        foreach ($rssFeed->channel->item as $item) {
            if ($itemCount < $this->limit) {
                $this->items[] = [
                    'title' => $item->title,
                    'link' => $item->link,
                    'pubDate' => $item->pubDate,
                    'description' => $item->description,
                ];
            } else {
                continue;
            }
            $itemCount++;
        }
    }
}
