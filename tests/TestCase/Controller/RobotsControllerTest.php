<?php

declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * SeoBakery\Controller\RobotsController Test Case
 *
 * @uses \SeoBakery\Controller\RobotsController
 */
class RobotsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.SeoBakery.Robots',
    ];
}
