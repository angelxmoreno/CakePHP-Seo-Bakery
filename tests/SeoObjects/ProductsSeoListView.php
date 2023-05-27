<?php
declare(strict_types=1);

namespace SeoBakery\Test\SeoObjects;

use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Core\SeoAwareListViewObject;

class ProductsSeoListView extends SeoAwareListViewObject implements SeoAwareInterface
{
    protected function getTableName(): string
    {
        return 'Products';
    }
}
