<?php
declare(strict_types = 1);

namespace Haassie\Dashboard\Widgets\Types;

interface WidgetTypeInterface
{
    public function __construct(array $config);
    public function renderHTML(array $settings = []): string;
}