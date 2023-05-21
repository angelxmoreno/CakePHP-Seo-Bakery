<?php

namespace SeoBakery\Test\TestCase\Builder\Entity;

use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;
use SeoBakery\Builder\Entity\MetaDescriptionBuilder;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertSame;

class MetaDescriptionBuilderTest extends TestCase
{
    /**
     * Test subject
     */
    protected MetaDescriptionBuilder $Builder;


    public function setUp(): void
    {
        parent::setUp();
        $this->Builder = new MetaDescriptionBuilder();
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
