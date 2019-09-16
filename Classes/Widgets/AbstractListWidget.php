<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

abstract class AbstractListWidget extends AbstractWidget
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var string
     */
    protected $templateName = 'ListWidget';

    public function __construct()
    {
        $this->height = 2;
        $this->width = 1;
    }

    /**
     * @return string
     */
    public function renderWidgetContent(): string
    {
        $this->prepareData();
        $this->initializeView();

        $this->view->assign('title', $this->title);
        $this->view->assign('items', $this->items);

        return $this->view->render();
    }
}
