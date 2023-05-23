<?php
declare(strict_types=1);

namespace SeoBakery\View;

use Cake\View\View;
use SeoBakery\View\Helper\DashboardHelper;

/**
 * @property-read DashboardHelper $Dashboard
 */
class AppView extends View
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadHelper('SeoBakery.Dashboard');
    }
}
