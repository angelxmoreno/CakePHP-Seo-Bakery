<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use SeoBakery\View\Helper\DashboardHelper;

/**
 * SeoBakery\View\Helper\DashboardHelper Test Case
 */
class DashboardHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var DashboardHelper
     */
    protected $Dashboard;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Dashboard = new DashboardHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Dashboard);

        parent::tearDown();
    }
}
