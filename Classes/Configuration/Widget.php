<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Configuration;

/**
 * Class Widget
 * This class represents the definition of an available widget.
 * The scope of this class is only the configuration not a representation of a concrete widget instance.
 */
class Widget extends AbstractConfiguration
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $className;

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getClassname(): string
    {
        return $this->className;
    }
}
