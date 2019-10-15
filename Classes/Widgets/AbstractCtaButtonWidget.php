<?php
declare(strict_types=1);

namespace FriendsOfTYPO3\Dashboard\Widgets;

abstract class AbstractCtaButtonWidget extends AbstractWidget
{
    protected $link = 'https://www.typo3.org';
    protected $label = 'TYPO3';

    protected $iconIdentifier = 'dashboard-cta';

    /**
     * @var string
     */
    protected $templateName = 'CtaWidget';

    public function __construct()
    {
        AbstractWidget::__construct();
    }

    public function prepareData(): void
    {
       $this->view->assign('link', $this->link);
       $this->view->assign('label', $this->label);
    }
}
