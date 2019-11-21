<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

class DocumentationWidget extends AbstractCtaButtonWidget
{
    protected $title = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.documentation.title';
    protected $description = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.documentation.description';
    protected $label = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.documentation.content.label';
    protected $link = 'https://docs.typo3.org';
}
