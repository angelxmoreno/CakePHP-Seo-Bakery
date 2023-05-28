<?php

declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * SeoBakery\Controller\SitemapsController Test Case
 *
 * @uses \SeoBakery\Controller\SitemapsController
 */
class SitemapsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.SeoBakery.Sitemaps',
    ];
}
