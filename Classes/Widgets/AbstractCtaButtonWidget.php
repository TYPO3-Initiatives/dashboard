<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\Interfaces\AdditionalCssInterface;

/**
 * The AbstractCtaButtonWidget class is the basic widget class for simple CTA widgets.
 * Is it possible to extends this class for own widgets.
 * Simply overwrite $this->link and $this->label to make use of this widget type.
 * More information can be found in the documentation.
 * @TODO: Add link to documentation
 */
abstract class AbstractCtaButtonWidget extends AbstractWidget implements AdditionalCssInterface
{
    protected $link = 'https://www.typo3.org';
    protected $label = 'TYPO3';
    protected $icon;
    protected $iconIdentifier = 'dashboard-cta';
    protected $templateName = 'CtaWidget';

    public function __construct()
    {
        parent::__construct();
        $this->height = 1;

        $this->view->assignMultiple([
            'link' => $this->link,
            'label' => $this->label,
            'icon' => $this->icon
        ]);
    }

    /**
     * This method returns an array with paths to required CSS files.
     * e.g. ['EXT:myext/Resources/Public/Css/my_widget.css']
     * @return array
     */
    public function getCssFiles(): array
    {
        return ['EXT:dashboard/Resources/Public/CSS/ctaWidget.min.css'];
    }
}
