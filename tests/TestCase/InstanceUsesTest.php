<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase;

use Cake\TestSuite\TestCase;
use SeoBakery\Core\SeoAwareEntityTrait;
use SeoBakery\Shared\InstanceUses;
use SeoBakery\Test\SeoObjects\Product;
use SeoBakery\Test\SeoObjects\ProductExtended;

class InstanceUsesTest extends TestCase
{
    public function testCheck(): void
    {
        $this->assertFalse(InstanceUses::check(new Product(), SeoAwareEntityTrait::class));
        $this->assertTrue(InstanceUses::check(new ProductExtended(), SeoAwareEntityTrait::class));
    }
}
