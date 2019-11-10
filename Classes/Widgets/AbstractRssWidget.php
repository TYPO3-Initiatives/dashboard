<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\Interfaces\AdditionalCssInterface;
use RuntimeException;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
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

    protected $lifeTime = 900;

    protected $iconIdentifier = 'dashboard-rss';

    protected $templateName = 'RssWidget';

    /**
     * @var FrontendInterface
     */
    protected $cache;

    public function __construct(FrontendInterface $cache = null)
    {
        AbstractListWidget::__construct();
        $this->cache = $cache ?? GeneralUtility::makeInstance(CacheManager::class)
            ->getCache('dashboard_rss');
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
        $cacheHash = md5($this->rssFile);
        if ($this->cache->has($cacheHash)) {
            $this->items = $this->cache->get($cacheHash);
            return;
        }

        /** @var \SimpleXMLElement $rssFeed */
        $rssContent = GeneralUtility::getUrl($this->rssFile);
        if ($rssContent === false) {
            throw new RuntimeException('RSS URL could not be fetched', 1573385431);
        }
        $rssFeed = simplexml_load_string($rssContent);
        $itemCount = 0;
        foreach ($rssFeed->channel->item as $item) {
            if ($itemCount < $this->limit) {
                $this->items[] = [
                    'title' => (string)$item->title,
                    'link' => (string)$item->link,
                    'pubDate' => (string)$item->pubDate,
                    'description' => (string)$item->description,
                ];
            } else {
                continue;
            }
            $itemCount++;
        }
        $this->cache->set($cacheHash, $this->items, ['dashboard_rss'], $this->lifeTime);
    }
}
