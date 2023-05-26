<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Core;

use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Test\SeoObjects\ProductExtended;

class SeoAwareEntityExtendedTest extends SeoAwareEntityWrapperTest
{
    public const ENTITY_CLASS = ProductExtended::class;

    public function setUp(): void
    {
        parent::setUp();
        /** @var ProductExtended|SeoAwareInterface $entity */
        $entity = $this->getTableInstance()->newEntity($this->data);
        $this->object = $entity;
    }

    public function testBuildMetaTitleFallback(): void
    {
        $this->assertSame($this->data['name'] . ' Extended', $this->object->buildMetaTitleFallback('view'));
    }

    public function testBuildMetaDescriptionFallback(): void
    {
        $this->assertSame('Extended ' . $this->data['description'], $this->object->buildMetaDescriptionFallback('view'));
    }

    public function testBuildMetaKeywordsFallback(): void
    {
        $keywords = [$this->data['name'], $this->data['description'], 'Extended'];
        $this->assertEqualsCanonicalizing($keywords, $this->object->buildMetaKeywordsFallback('view'));
    }

    public function testBuildRobotsShouldIndex(): void
    {
        $this->assertFalse($this->object->buildRobotsShouldIndex('view'));
    }

    public function testBuildRobotsShouldFollow(): void
    {
        $this->assertFalse($this->object->buildRobotsShouldFollow('view'));
    }

    public function testGetPrefixPluginControllerArray(): void
    {
        $this->assertEqualsCanonicalizing([
            'prefix' => false,
            'plugin' => 'Store',
            'controller' => 'Items',
        ], $this->object->getPrefixPluginControllerArray());
    }

    public function testBuildUrl(): void
    {
        $this->assertSame('/store/item/productAlpha', $this->object->buildUrl('view'));
    }
}
