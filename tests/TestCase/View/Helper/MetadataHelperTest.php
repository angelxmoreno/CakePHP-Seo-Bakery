<?php

declare(strict_types=1);

namespace SeoBakery\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use SeoBakery\View\Helper\MetadataHelper;

/**
 * SeoBakery\View\Helper\MetadataHelper Test Case
 */
class MetadataHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var MetadataHelper
     */
    protected $Metadata;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Metadata = new MetadataHelper($view);
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
