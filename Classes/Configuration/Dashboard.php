<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Configuration;

/**
 * Class Dashboard
 * @internal
 */
class Dashboard extends AbstractConfiguration
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
