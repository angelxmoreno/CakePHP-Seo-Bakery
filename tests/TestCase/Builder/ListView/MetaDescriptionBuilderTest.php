<?php

namespace SeoBakery\Test\TestCase\Builder\ListView;

use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use SeoBakery\Builder\ListView\MetaDescriptionBuilder;

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

    public function testInvocationWithNoAssociations(): void
    {
        $expected = 'List of Brands';
        $table = new Table(['alias' => 'Brands']);
        $method = $this->Builder;

        $metaDescription = $method($table);

        assertIsString($metaDescription);
        assertSame($metaDescription, $expected);
    }

    public function testInvocationWithSingleAssociations(): void
    {
        $expected = 'List of Brands and Products';
        $table = new Table(['alias' => 'Brands']);
        $table->hasMany('Products');
        $method = $this->Builder;

        $metaDescription = $method($table);

        assertIsString($metaDescription);
        assertSame($metaDescription, $expected);
    }

    public function testInvocationWithAssociations(): void
    {
        $expected = 'List of Products, Product Variations, Brands and Vendors';
        $table = new Table(['alias' => 'Products']);
        $table->hasMany('ProductVariations');
        $table->belongsTo('Brands');
        $table->hasOne('Vendor');
        $method = $this->Builder;

        $metaDescription = $method($table);

        assertIsString($metaDescription);
        assertSame($metaDescription, $expected);
    }
}
