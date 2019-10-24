<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Controller;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Localization\LanguageService;

/**
 * Class AbstractController
 * @codeCoverageIgnore no coverage for controllers yet
 */
class AbstractController
{
    private const MODULE_DATA_CURRENT_DASHBOARD_IDENTIFIER = 'web_dashboard/current_dashboard/';

    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    protected function getCurrentDashboard(): string
    {
        return $this->getBackendUser()->getModuleData(self::MODULE_DATA_CURRENT_DASHBOARD_IDENTIFIER) ?? '';
    }

    protected function setCurrentDashboard(string $identifier): void
    {
        $this->getBackendUser()->pushModuleData(self::MODULE_DATA_CURRENT_DASHBOARD_IDENTIFIER, $identifier);
    }
}
