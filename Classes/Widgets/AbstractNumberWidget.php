<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\Interfaces\AdditionalCssInterface;

/**
 * The AbstractNumberWidget class is the basic widget class to display a simple number.
 * Is it possible to extends this class for own widgets.
 * In your class you have to set $this->number with the number to display.
 * More information can be found in the documentation.
 * @TODO: Add link to documentation
 */
abstract class AbstractNumberWidget extends AbstractWidget implements AdditionalCssInterface
{
    protected $number;

    protected $templateName = 'NumberWidget';

    protected $iconIdentifier = 'dashboard-hashtag';

    protected $icon;

    public function __construct()
    {
        parent::__construct();
        $this->height = 2;
        $this->width = 2;
    }

    public function renderWidgetContent(): string
    {
        $this->view->assign('icon', $this->icon);
        $this->view->assign('title', $this->title);
        $this->view->assign('number', $this->number);
        return $this->view->render();
    }

    /**
     * This method returns an array with paths to required CSS files.
     * e.g. ['EXT:myext/Resources/Public/Css/my_widget.css']
     * @return array
     */
    public function getCssFiles(): array
    {
        return ['EXT:dashboard/Resources/Public/CSS/numberWidget.min.css'];
    }
}
