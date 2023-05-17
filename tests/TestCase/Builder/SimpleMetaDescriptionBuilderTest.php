<?php

namespace SeoBakery\Test\TestCase\Builder;

use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;
use SeoBakery\Builder\SimpleMetaDescriptionBuilder;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertSame;

class SimpleMetaDescriptionBuilderTest extends TestCase
{
    /**
     * Test subject
     */
    protected SimpleMetaDescriptionBuilder $Builder;


    public function setUp(): void
    {
        parent::setUp();
        $this->Builder = new SimpleMetaDescriptionBuilder();
    }

    public function tearDown(): void
    {
        unset($this->Builder);
        parent::tearDown();
    }

    public function testInvocation(): void
    {
        $action = 'view';
        $data = [
            'title' => 'This is the title',
            'description' => 'This is the description',
        ];
        $entity = new Entity($data);
        $method = $this->Builder;

        $metaDescription = $method($entity, $action);

        assertIsString($metaDescription);
        assertSame($metaDescription, $data['description']);
    }
}
