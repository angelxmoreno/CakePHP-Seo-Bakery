<?php

declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Command;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use SeoBakery\Command\GenerateSeoAwareListViewObjectCommand;

/**
 * SeoBakery\Command\GenerateSeoAwareListViewObjectCommand Test Case
 *
 * @uses GenerateSeoAwareListViewObjectCommand
 */
class GenerateSeoAwareListViewObjectCommandTest extends TestCase
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
