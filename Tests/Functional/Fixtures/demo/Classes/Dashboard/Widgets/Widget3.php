<?php
declare(strict_types=1);

namespace DEMO\Demo\Dashboard\Widgets;

use FriendsOfTYPO3\Dashboard\Widgets\AbstractDoughnutChartWidget;

class Widget3 extends AbstractDoughnutChartWidget
{
    protected $extensionKey = 'demo';

    protected $title = 'Title: Widget 3';
    protected $iconIdentifier = 'demo-widget3';
    protected $height = 4;
    protected $score = 0;
    protected $lastCheck = 0;

    protected function prepareChartData(): void
    {
        parent::prepareChartData();
        $this->chartData = $this->getChartData();
    }

    public function renderWidgetContent(): string
    {
        $this->prepareData();
        $this->initializeView();

        $this->view->assign('title', $this->title);
        $this->view->assign('value', $this->score);
        $this->view->assign('lastCheck', $this->lastCheck);

        return $this->view->render();
    }

    protected function getChartData(): array
    {
        $labels = ['', ''];
        $data = [$this->score, 100 - $this->score];

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'backgroundColor' => [$this->chartColors[0], '#fff'],
                    'data' => $data
                ]
            ],
        ];
    }

    public function prepareData(): void
    {
        // TODO: Implement prepareData() method.
    }
}
