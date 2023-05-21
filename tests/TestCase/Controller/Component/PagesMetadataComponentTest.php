<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Controller\Component;

use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use SeoBakery\Controller\Component\PagesMetadataComponent;

/**
 * SeoBakery\Controller\Component\PagesMetadataComponent Test Case
 */
class PagesMetadataComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var PagesMetadataComponent
     */
    protected $PagesMetadata;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->PagesMetadata = new PagesMetadataComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PagesMetadata);

        parent::tearDown();
    }
}
