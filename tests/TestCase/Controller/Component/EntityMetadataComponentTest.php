<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use SeoBakery\Controller\Component\EntityMetadataComponent;

/**
 * SeoBakery\Controller\Component\EntityMetadataComponent Test Case
 */
class EntityMetadataComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var EntityMetadataComponent
     */
    protected $EntityMetadata;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->EntityMetadata = new EntityMetadataComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->EntityMetadata);

        parent::tearDown();
    }

    /**
     * Test beforeRender method
     *
     * @return void
     * @uses EntityMetadataComponent::beforeRender
     */
    public function testBeforeRender(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test setTableLocator method
     *
     * @return void
     * @uses EntityMetadataComponent::setTableLocator
     */
    public function testSetTableLocator(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getTableLocator method
     *
     * @return void
     * @uses EntityMetadataComponent::getTableLocator
     */
    public function testGetTableLocator(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test fetchTable method
     *
     * @return void
     * @uses EntityMetadataComponent::fetchTable
     */
    public function testFetchTable(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
