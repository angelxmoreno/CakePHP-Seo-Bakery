<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Command;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * SeoBakery\Command\BackFillSeoMetadataCommand Test Case
 *
 * @uses \SeoBakery\Command\BackFillSeoMetadataCommand
 */
class BackFillSeoMetadataCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCommandRunner();
    }
}
