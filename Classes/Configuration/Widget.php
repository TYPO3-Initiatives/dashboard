<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Configuration;

/**
 * Class Widget
 * @internal
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
