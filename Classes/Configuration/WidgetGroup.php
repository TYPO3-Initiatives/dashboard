<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Configuration;

/**
 * Class WidgetGroup
 * This class represents the definition of an available widget group.
 * The scope of this class is only the configuration not a representation of a concrete widget group instance.
 */
class WidgetGroup extends AbstractConfiguration
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $label;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
