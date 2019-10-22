<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard;

use FriendsOfTYPO3\Dashboard\Configuration\Dashboard;
use FriendsOfTYPO3\Dashboard\Configuration\Widget;
use Symfony\Component\Finder\Finder;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\Loader\YamlFileLoader;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class DashboardConfiguration
 * @internal
 */
class DashboardConfiguration implements SingletonInterface
{
    /**
     * Config yaml file name.
     *
     * @internal
     * @var string
     */
    protected $configFileName = 'Dashboard.yaml';

    /**
     * Identifier to store all configuration data in cache_core cache.
     *
     * @internal
     * @var string
     */
    protected $cacheIdentifier = 'dashboard-configuration';

    /**
     * Cache stores all configuration as Dashboard objects, as long as they haven't been changed.
     * This drastically improves performance
     *
     * @var array|null
     */
    protected $firstLevelCacheDashboards;

    /**
     * Cache stores all configuration as Dashboard objects, as long as they haven't been changed.
     * This drastically improves performance
     *
     * @var array|null
     */
    protected $firstLevelCacheWidgets;

    /**
     * @var PackageManager
     */
    protected $packageManager;

    public function __construct(PackageManager $packageManager = null)
    {
        $this->packageManager = $packageManager ?? GeneralUtility::makeInstance(PackageManager::class);
    }

    /**
     * Return all dashboard objects which have been found in the filesystem.
     *
     * @return Dashboard[]
     */
    public function getDashboards(): array
    {
        return $this->firstLevelCacheDashboards ?? $this->resolveAllExistingDashboards();
    }

    /**
     * Return all wizards objects which have been found in the filesystem.
     *
     * @return Widget[]
     */
    public function getWidgets(): array
    {
        return $this->firstLevelCacheWidgets ?? $this->resolveAllExistingWidgets();
    }

    /**
     * Resolve all dashboard objects which have been found in the filesystem.
     *
     * @param bool $useCache
     * @return Dashboard[]
     */
    protected function resolveAllExistingDashboards(bool $useCache = true): array
    {
        $dashboards = [];
        $dashboardConfiguration = $this->getAllDashboardConfigurationFromFiles($useCache);
        foreach ($dashboardConfiguration['Dashboard']['Dashboards'] ?? [] as $configuration) {
            $dashboards[$configuration['identifier']] = GeneralUtility::makeInstance(Dashboard::class, $configuration);
        }
        $this->firstLevelCacheDashboards = $dashboards;
        return $dashboards;
    }

    /**
     * Resolve all widgets objects which have been found in the filesystem.
     *
     * @param bool $useCache
     * @return Widget[]
     */
    protected function resolveAllExistingWidgets(bool $useCache = true): array
    {
        $widgets = [];
        $dashboardConfiguration = $this->getAllDashboardConfigurationFromFiles($useCache);
        foreach ($dashboardConfiguration['Dashboard']['Widgets'] ?? [] as $configuration) {
            $widgets[$configuration['identifier']] = GeneralUtility::makeInstance(Widget::class, $configuration);
        }
        $this->firstLevelCacheWidgets = $widgets;
        return $widgets;
    }

    /**
     * Read the dashboard configuration from config files.
     *
     * @param bool $useCache
     * @return array
     * @throws NoSuchCacheException
     */
    protected function getAllDashboardConfigurationFromFiles(bool $useCache = true): array
    {
        // Check if the data is already cached
        if ($useCache && $dashboardConfiguration = $this->getCache()->get($this->cacheIdentifier)) {
            // Due to the nature of PhpFrontend, the `<?php` and `#` wraps have to be removed
            $dashboardConfiguration = preg_replace('/^<\?php\s*|\s*#$/', '', $dashboardConfiguration);
            $dashboardConfiguration = json_decode($dashboardConfiguration, true);
        }

        if (empty($dashboardConfiguration)) {
            $paths = [];
            foreach ($this->packageManager->getActivePackages() as $package) {
                $tmpPath = $package->getPackagePath() . 'Configuration/Backend/';
                if (file_exists($tmpPath)) {
                    $paths[] = $tmpPath;
                }
            }

            $finder = new Finder();
            try {
                $finder->files()->depth(0)->in($paths)->name($this->configFileName);
            } catch (\InvalidArgumentException $e) {
                $finder = [];
            }
            $loader = GeneralUtility::makeInstance(YamlFileLoader::class);
            $dashboardConfiguration = [];
            foreach ($finder as $fileInfo) {
                $configuration = $loader->load(GeneralUtility::fixWindowsFilePath((string)$fileInfo));
                ArrayUtility::mergeRecursiveWithOverrule($dashboardConfiguration, $configuration);
            }
            $this->getCache()->set($this->cacheIdentifier, json_encode($dashboardConfiguration));
        }
        return $dashboardConfiguration ?? [];
    }

    /**
     * Short-hand function for the cache
     *
     * @return FrontendInterface
     * @throws NoSuchCacheException
     */
    protected function getCache(): FrontendInterface
    {
        // @TODO: cache identifier "cache_core" is deprecated since v10 and must be changed to "core" with v11
        return GeneralUtility::makeInstance(CacheManager::class)->getCache('cache_core');
    }
}
