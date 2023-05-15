<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Model\Behavior;

use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use SeoBakery\Model\Behavior\MetadataBehavior;

/**
 * SeoBakery\Model\Behavior\MetadataBehavior Test Case
 */
class MetadataBehaviorTest extends TestCase
{
    /**
     * Test subject
     *
     * @var MetadataBehavior
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
        $table = new Table();
        $this->Metadata = new MetadataBehavior($table);
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
