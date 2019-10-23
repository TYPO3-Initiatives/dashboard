<?php

declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Tests\Functional\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\AbstractWidget;
use Prophecy\Argument;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class AbstractWidgetTestCase extends FunctionalTestCase
{
    /**
     * @var AbstractWidget
     */
    protected $widget;

    /**
     * @var string
     */
    protected $widgetClassName;

    /**
     * @var string
     */
    protected $expectedTitle;

    /**
     * @var string
     */
    protected $expectedDescription = '';

    /**
     * @var string
     */
    protected $expectedIconIdentifier = '';

    /**
     * @var int
     */
    protected $expectedHeight = 0;

    /**
     * @var int
     */
    protected $expectedWidth = 0;

    /**
     * @var array
     */
    protected $expectedCssFiles = [];

    /**
     * @var array
     */
    protected $expectedJsFiles = [];

    /**
     * @var string
     */
    protected $expectedAdditionalClasses = '';

    public function setUp(): void
    {
        $languageServiceProphecy = $this->prophesize(LanguageService::class);
        $languageServiceProphecy->sL(Argument::any())->willReturn('something');
        $GLOBALS['LANG'] = $languageServiceProphecy->reveal();

        $this->coreExtensionsToLoad[] = 'seo';
        $this->testExtensionsToLoad[] = 'typo3conf/ext/dashboard';
        $this->testExtensionsToLoad[] = 'typo3conf/ext/dashboard/Tests/Functional/Fixtures/demo';
        parent::setUp();
        $this->importDataSet(__DIR__ . '/../Fixtures/pages.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/be_users.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/sys_log.xml');
        $this->widget = GeneralUtility::makeInstance($this->widgetClassName);
    }

    /**
     * @test
     */
    public function getTitleReturnsExpectedString(): void
    {
        $this->assertSame($this->expectedTitle, $this->widget->getTitle());
    }

    /**
     * @test
     */
    public function getDescriptionReturnsExpectedString(): void
    {
        $this->assertSame($this->expectedDescription, $this->widget->getDescription());
    }

    /**
     * @test
     */
    public function getIconIdentifierReturnsExpectedString(): void
    {
        $this->assertSame($this->expectedIconIdentifier, $this->widget->getIconIdentifier());
    }

    /**
     * @test
     */
    public function getHeightReturnsExpectedInteger(): void
    {
        $this->assertSame($this->expectedHeight, $this->widget->getHeight());
    }

    /**
     * @test
     */
    public function getWidthReturnsExpectedInteger(): void
    {
        $this->assertSame($this->expectedWidth, $this->widget->getWidth());
    }

    /**
     * @test
     */
    public function getCssFilesReturnsExpectedArray(): void
    {
        $this->assertSame($this->expectedCssFiles, $this->widget->getCssFiles());
    }

    /**
     * @test
     */
    public function getJsFilesReturnsExpectedArray(): void
    {
        $this->assertSame($this->expectedJsFiles, $this->widget->getJsFiles());
    }

    /**
     * @test
     */
    public function getAdditionalClassesReturnsExpectedString(): void
    {
        $this->assertSame($this->expectedAdditionalClasses, $this->widget->getAdditionalClasses());
    }
}
