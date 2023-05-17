<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use SeoBakery\Controller\Component\MetadataComponent;

/**
 * SeoBakery\Controller\Component\MetadataComponent Test Case
 */
class MetadataComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var MetadataComponent
     */
    protected MetadataComponent $Metadata;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Metadata = new MetadataComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Metadata);

        parent::tearDown();
    }
}
