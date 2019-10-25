<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

/**
 * The AbstractListWidget class is the basic widget class for structured content.
 * Is it possible to extends this class for own widgets.
 * In your class you have to set $this->items with the data to display.
 * More information can be found in the documentation.
 * @TODO: Add link to documentation
 */
abstract class AbstractListWidget extends AbstractWidget
{
    protected $items = [];

    protected $iconIdentifier = 'dashboard-bars';

    protected $limit = 5;

    protected $totalItems = 0;

    protected $templateName = 'ListWidget';

    public function __construct()
    {
        parent::__construct();
        $this->height = 4;
        $this->width = 2;
    }

    public function renderWidgetContent(): string
    {
        $this->view->assign('title', $this->title);
        $this->view->assign('items', $this->items);
        $this->view->assign('totalNumberOfItems', $this->totalItems);
        return $this->view->render();
    }
}
