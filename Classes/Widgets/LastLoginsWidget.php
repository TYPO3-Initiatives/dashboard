<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

class LastLoginsWidget extends AbstractListWidget
{
    public function __construct()
    {
        AbstractListWidget::__construct();
        $this->width = 2;
        $this->height = 1;
        $this->title = 'Recent logins';
    }

    public function prepareData(): void
    {
        $this->items = [
            [
                'title' => 'This is a title 1',
                'link' => 't3://page?uid=1'
            ],
            [
                'title' => 'This is a title 2',
                'link' => 't3://page?uid=81'
            ],
        ];
    }
}
