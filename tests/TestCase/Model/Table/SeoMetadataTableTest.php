<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use SeoBakery\Model\Table\SeoMetadataTable;

/**
 * SeoBakery\Model\Table\SeoMetadataTable Test Case
 */
class SeoMetadataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var SeoMetadataTable
     */
    protected $SeoMetadata;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.SeoBakery.SeoMetadata',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SeoMetadata') ? [] : ['className' => SeoMetadataTable::class];
        $this->SeoMetadata = $this->getTableLocator()->get('SeoMetadata', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SeoMetadata);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \SeoBakery\Model\Table\SeoMetadataTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \SeoBakery\Model\Table\SeoMetadataTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
