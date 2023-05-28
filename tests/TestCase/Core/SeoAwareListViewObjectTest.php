<?php

declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Core;

use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Core\SeoAwareListViewObject;
use SeoBakery\Test\SeoObjects\ProductsSeoListView;

class SeoAwareListViewObjectTest extends AbstractSeoAware
{
    public function setUp(): void
    {
        parent::setUp();
        /** @var SeoAwareListViewObject|SeoAwareInterface $object */
        $object = new ProductsSeoListView();
        $this->object = $object;
    }

    public function testBuildMetaTitleFallback(): void
    {
        $this->assertSame('Products', $this->object->buildMetaTitleFallback('view'));
    }

    public function testBuildMetaDescriptionFallback(): void
    {
        $this->assertSame('List of Products', $this->object->buildMetaDescriptionFallback('view'));
    }

    public function testBuildMetaKeywordsFallback(): void
    {
        $this->assertEqualsCanonicalizing(['Product'], $this->object->buildMetaKeywordsFallback('view'));
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
        $this->assertSame('/products', $this->object->buildUrl('index'));
    }
}
