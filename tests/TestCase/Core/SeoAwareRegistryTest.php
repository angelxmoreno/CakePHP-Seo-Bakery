<?php

declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Core;

use Cake\TestSuite\TestCase;
use ReflectionClass;
use ReflectionException;
use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Core\SeoAwareItem;
use SeoBakery\Core\SeoAwareRegistry;
use SeoBakery\Test\SeoObjects\AboutUsSeoPageObject;
use SeoBakery\Test\SeoObjects\ProductExtended;
use SeoBakery\Test\SeoObjects\ProductsSeoListViewObject;

class SeoAwareRegistryTest extends TestCase
{
    protected SeoAwareRegistry $registry;
    protected ReflectionClass $reflectedSeoAwareRegistry;

    /**
     * @throws ReflectionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->reflectedSeoAwareRegistry = new ReflectionClass(SeoAwareRegistry::class);
        $this->registry = $this->reflectedSeoAwareRegistry->newInstanceWithoutConstructor();
        $this->registry::clear();
        $this->registry::$seoClassNS = 'SeoBakery\Test\SeoObjects';
        $this->registry::$seoClassPath = SEO_OBJ_DIR;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->registry::clear();
        unset($this->reflectedSeoAwareRegistry, $this->registry);
    }

    /**
     * @throws ReflectionException
     */
    protected function invokeProtectedMethod(string $methodName, array $args)
    {
        $method = $this->reflectedSeoAwareRegistry->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($this->registry, $args);
    }

    /**
     * @throws ReflectionException
     */
    public function testAdd(): void
    {
        $object = new AboutUsSeoPageObject();
        $name = $this->invokeProtectedMethod(
            'keyFromRouteArray',
            [$object->getPrefixPluginControllerArray()]
        );

        $this->assertEmpty($this->registry::$objects);
        $this->registry::add($object);
        $this->assertNotEmpty($this->registry::$objects);
        $this->assertArrayHasKey($name, $this->registry::$objects);
        $objects = $this->registry::$objects;
        $this->assertSame(1, count($objects[$name]));
        $this->assertSame($object, $objects[$name][0]->getInstance());
    }

    public function testGetItems(): void
    {
        $set = [
            SeoAwareItem::TYPE_PAGE => new AboutUsSeoPageObject(),
            SeoAwareItem::TYPE_LIST_VIEW => new ProductsSeoListViewObject(),
            SeoAwareItem::TYPE_ENTITY => new ProductExtended(),
        ];
        foreach ($set as $type => $object) {
            $this->registry::add($object);
            $this->assertItemKeys($type, $object);
        }
    }

    protected function assertItemKeys(string $type, SeoAwareInterface $seoObj): void
    {
        $items = $this->registry::getItems();
        $this->assertArrayHasKey($type, $items);
        $this->assertSame(1, count($items[$type]));
        $this->assertSame($seoObj, $items[$type][0]->getInstance());
    }

    public function testClear(): void
    {
        $object = new AboutUsSeoPageObject();
        $this->assertEmpty($this->registry::$objects);
        $this->registry::add($object);
        $this->assertNotEmpty($this->registry::$objects);
        $this->registry::clear();
        $this->assertEmpty($this->registry::$objects);
    }

    public function testGetFromRequest(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testScan(): void
    {
        $this->registry::scan();
        $plucker = function (string $type) {
            foreach ($this->registry::$objects as $group) {
                foreach ($group as $item) {
                    if ($item->getType() === $type) {
                        return $item->getInstance();
                    }
                }
            }
        };
        $set = [
            SeoAwareItem::TYPE_PAGE,
            SeoAwareItem::TYPE_LIST_VIEW,
        ];
        foreach ($set as $type) {
            $object = $plucker($type);
            $this->assertItemKeys($type, $object);
        }
    }
}
