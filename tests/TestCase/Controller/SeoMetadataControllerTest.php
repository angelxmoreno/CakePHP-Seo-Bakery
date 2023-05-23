<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use SeoBakery\Controller\SeoMetadataController;

/**
 * SeoBakery\Controller\SeoMetadataController Test Case
 *
 * @uses SeoMetadataController
 */
class SeoMetadataControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.SeoBakery.SeoMetadata',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses SeoMetadataController::index
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses SeoMetadataController::view
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses SeoMetadataController::add
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses SeoMetadataController::edit
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses SeoMetadataController::delete
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
