<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Configuration;

/**
 * Class Dashboard
 * This class represents the definition of an available dashboard.
 * The scope of this class is only the configuration not a representation of a concrete dashboard instance.
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
    protected $iconIdentifier = 'dashboard-default';

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

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getExcludeFromWizard(): bool
    {
        return $this->excludeFromWizard;
    }

    /**
     * @param bool $excludeFromWizard
     */
    public function setExcludeFromWizard(bool $excludeFromWizard): void
    {
        $this->excludeFromWizard = $excludeFromWizard;
    }

    public function getIconIdentifier(): string
    {
        return $this->iconIdentifier;
    }

    /**
     * @param string $iconIdentifier
     */
    public function setIconIdentifier(string $iconIdentifier): void
    {
        $this->iconIdentifier = $iconIdentifier;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string[]
     */
    public function getWidgets(): array
    {
        return $this->widgets;
    }

    /**
     * @param string[] $widgets
     */
    public function setWidgets(array $widgets): void
    {
        $this->widgets = $widgets;
    }
}
