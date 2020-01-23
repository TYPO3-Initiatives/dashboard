<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\DocumentationWidget;

class DocumentationWidgetTest extends AbstractWidgetTestCase
{
    protected $widgetClassName = DocumentationWidget::class;

    protected $expectedTitle = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.documentation.title';
    protected $expectedDescription = 'LLL:EXT:dashboard/Resources/Private/Language/locallang.xlf:widgets.documentation.description';
    protected $expectedWidth = 2;
    protected $expectedHeight = 1;
    protected $expectedIconIdentifier = 'dashboard-cta';
    protected $expectedCssFiles = ['EXT:dashboard/Resources/Public/CSS/ctaWidget.min.css'];

    /**
     * @test
     */
    public function renderWidgetContentContainsExpectedMarkup(): void
    {
        $markup = $this->widget->renderWidgetContent();
        $this->assertStringContainsString('TYPO3 documentation', $markup);
        $this->assertStringContainsString('<a class="widget-cta" target="_blank" href="https://docs.typo3.org">', $markup);
    }
}
