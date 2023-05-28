<?php

declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Core;

use SeoBakery\Test\SeoObjects\AboutUsSeoPage;

class SeoAwarePageObjectTest extends AbstractSeoAware
{
    public function setUp(): void
    {
        parent::setUp();
        $this->object = new AboutUsSeoPage();
    }

    public function testBuildMetaTitleFallback(): void
    {
        $this->assertSame('Profile About', $this->object->buildMetaTitleFallback('view'));
    }

    public function testBuildMetaDescriptionFallback(): void
    {
        $this->assertSame('The Profile About page', $this->object->buildMetaDescriptionFallback('view'));
    }

    public function testBuildMetaKeywordsFallback(): void
    {
        $this->assertEqualsCanonicalizing(['Profile'], $this->object->buildMetaKeywordsFallback('view'));
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
            'controller' => 'Pages',
        ], $this->object->getPrefixPluginControllerArray());
    }

    public function testBuildUrl(): void
    {
        $this->assertSame('/pages/profile/about', $this->object->buildUrl('view'));
    }
}
