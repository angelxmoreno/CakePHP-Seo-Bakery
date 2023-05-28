<?php

declare(strict_types=1);

namespace SeoBakery\Shared;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;
use SeoBakery\Model\Table\SeoMetadataTable;

trait SeoMetadataTableAware
{
    use LocatorAwareTrait;

    /**
     * @return SeoMetadataTable|Table
     */
    protected function getSeoMetadataTable(): SeoMetadataTable
    {
        return $this->fetchTable(SeoMetadataTable::class);
    }
}
