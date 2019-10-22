<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Configuration;

/**
 * Class Dashboard
 * This class represents the definition of an available dashboard.
 * The scope of this class is only the configuration not a representation of a concrete dashboard instance.
 * @internal
 */
class Dashboard extends AbstractConfiguration
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var bool
     */
    protected $excludeFromWizard = false;

    /**
     * @var string
     */
    protected $iconIdentifier = 'dashboard-dashboard';

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string[]
     */
    protected $widgets = [];

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getExcludeFromWizard(): bool
    {
        return $this->excludeFromWizard;
    }

    public function getIconIdentifier(): string
    {
        return $this->iconIdentifier;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string[]
     */
    public function getWidgets(): array
    {
        return $this->widgets;
    }
}
