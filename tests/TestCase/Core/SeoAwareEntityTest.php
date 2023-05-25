<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Core;

use Cake\ORM\Table;
use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Test\SeoObjects\Product;

class SeoAwareEntityTest extends AbstractSeoAwareTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->data = [
            'id' => 999,
            'name' => 'Product Alpha',
            'description' => 'description of product Alpha',
        ];
        /** @var Table|SeoAwareInterface $object */
        $object = $this->getTableInstance()->newEntity($this->data);

        $this->object = $object;
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->data);
    }

    protected function assertEntityTrait(array $data): void
    {
        /** @var Product $entity */
        $entity = $this->Products->newEntity($data);

        $this->assertSame($data['name'], $entity->buildMetaTitleFallback('view'));
        $this->assertSame($data['description'], $entity->buildMetaDescriptionFallback('view'));
        $this->assertEqualsCanonicalizing($this->createExpectedKeywordsFromArray($data), $entity->buildMetaKeywordsFallback('view'));
        $this->assertTrue($entity->buildRobotsShouldIndex('view'));
        $this->assertEqualsCanonicalizing([
            'prefix' => false,
            'plugin' => false,
            'controller' => 'Products',
        ], $entity->getPrefixPluginControllerArray());
        $this->assertSame('/products/view/' . $data['id'], $entity->buildUrl('view'));
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
