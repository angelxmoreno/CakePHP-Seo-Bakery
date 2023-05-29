<?php

declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Core;

use Cake\Datasource\EntityInterface;
use Cake\TestSuite\TestCase;
use SeoBakery\Core\SeoAwareEntityTrait;
use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Core\SeoAwareItem;
use SeoBakery\Core\SeoAwareListViewObject;
use SeoBakery\Core\SeoAwarePageObject;
use SeoBakery\Test\SeoObjects\AboutUsSeoPageObject;
use SeoBakery\Test\SeoObjects\BadSeoAwareObj;
use SeoBakery\Test\SeoObjects\ProductExtended;
use SeoBakery\Test\SeoObjects\ProductsSeoListViewObject;
use UnexpectedValueException;

class SeoAwareItemTest extends TestCase
{
    /**
     * Test subject
     */
    protected SeoAwareItem $seoAwareItem;
    protected SeoAwarePageObject $pageObject;
    protected SeoAwareListViewObject $listViewObject;

    /**
     * @var EntityInterface|ProductExtended|SeoAwareEntityTrait
     */
    protected EntityInterface $entityObject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pageObject = new AboutUsSeoPageObject();
        $this->listViewObject = new ProductsSeoListViewObject();
        $this->entityObject = new ProductExtended();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->pageObject, $this->listViewObject, $this->entityObject);
    }

    protected function assertSeoAwareItemGetters(
        SeoAwareItem $seoAwareItem,
        SeoAwareInterface $instance,
        string $type,
        array $actions,
        string $className
    ): void {
        $this->assertSame(get_class($seoAwareItem->getInstance()), get_class($instance));
        $this->assertSame($seoAwareItem->getType(), $type);
        $this->assertSame($seoAwareItem->getActions(), $actions);
        $this->assertSame($seoAwareItem->getClassName(), get_class($instance));
    }

    public function testPageObjectGetters(): void
    {
        $object = $this->pageObject;
        $this->assertSeoAwareItemGetters(
            new SeoAwareItem($object),
            $object,
            SeoAwareItem::TYPE_PAGE,
            $object->actions(),
            get_class($object)
        );
    }

    public function testListViewObjectGetters(): void
    {
        $object = $this->listViewObject;
        $this->assertSeoAwareItemGetters(
            new SeoAwareItem($object),
            $object,
            SeoAwareItem::TYPE_LIST_VIEW,
            $object->actions(),
            get_class($object)
        );
    }

    public function testEntityObjectGetters(): void
    {
        $object = $this->entityObject;
        $this->assertSeoAwareItemGetters(
            new SeoAwareItem($object),
            $object,
            SeoAwareItem::TYPE_ENTITY,
            $object->actions(),
            get_class($object)
        );
    }

    public function testExceptionThrownWhenTypeIsUnknown(): void
    {
        $this->expectException(UnexpectedValueException::class);
        new SeoAwareItem(new BadSeoAwareObj());
    }
}
