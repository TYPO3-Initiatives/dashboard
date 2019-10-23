<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Controller;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Localization\LanguageService;

class AbstractController
{
    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * @return string
     */
    protected function getCurrentDashboard(): string
    {
        return $this->getBackendUser()->getModuleData('web_dashboard/current_dashboard/') ?: 'default';
    }
}
