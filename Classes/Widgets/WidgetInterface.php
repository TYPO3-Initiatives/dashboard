<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

/**
 * Interface WidgetInterface
 */
interface WidgetInterface
{
    public function getTitle(): string;
    public function getDescription(): string;
    public function getIconIdentifier(): string;
    public function getHeight(): int;
    public function getWidth(): int;
    public function renderWidgetContent(): string;
    public function getEventData(): array;
    public function getAdditionalClasses(): string;
    public function prepareData(): void;
    public function getCssFiles(): array;
    public function getJsFiles(): array;
}
