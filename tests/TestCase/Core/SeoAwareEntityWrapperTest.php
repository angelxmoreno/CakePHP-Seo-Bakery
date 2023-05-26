<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Core;

use SeoBakery\Core\SeoAwareEntityWrapper;
use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Test\SeoObjects\Product;

class SeoAwareEntityWrapperTest extends AbstractSeoAware
{
    public function setUp(): void
    {
        parent::setUp();
        $this->data = [
            'id' => 999,
            'name' => 'Product Alpha',
            'description' => 'description of product Alpha',
        ];
        /** @var Product|SeoAwareInterface $entity */
        $entity = $this->getTableInstance()->newEntity($this->data);

        $this->object = new SeoAwareEntityWrapper($entity, $this->getTableInstance());
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->data);
    }

    public function testBuildMetaTitleFallback(): void
    {
        $this->assertSame($this->data['name'], $this->object->buildMetaTitleFallback('view'));
    }

    public function testBuildMetaDescriptionFallback(): void
    {
        $this->assertSame($this->data['description'], $this->object->buildMetaDescriptionFallback('view'));
    }

    public function testBuildMetaKeywordsFallback(): void
    {
        $content = $this->data['name'] . ' ' . $this->data['description'];
        $keywords = $this->createExpectedKeywords($content);
        $this->assertEqualsCanonicalizing($keywords, $this->object->buildMetaKeywordsFallback('view'));
    }

    public function testBuildRobotsShouldIndex(): void
    {
        $this->assertTrue($this->object->buildRobotsShouldIndex('view'));
    }

    public function testBuildRobotsShouldFollow(): void
    {
        $this->assertTrue($this->object->buildRobotsShouldFollow('view'));
    }

    public function testGetPrefixPluginControllerArray(): void
    {
        $this->assertEqualsCanonicalizing([
            'prefix' => false,
            'plugin' => false,
            'controller' => 'Products',
        ], $this->object->getPrefixPluginControllerArray());
    }

    public function testBuildUrl(): void
    {
        $this->assertSame('/products/view/' . $this->data['id'], $this->object->buildUrl('view'));
    }
}
