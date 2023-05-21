<?php
declare(strict_types=1);

namespace SeoBakery\Builder\EntityAggregate;

use Cake\ORM\Table;
use SeoBakery\Builder\Base\EntityAggregateMetaBuilderBase;

class MetaTitle extends EntityAggregateMetaBuilderBase
{
    protected static int $limit = 60;

    public function __invoke(Table $table, string $action = 'view'): string
    {
        return substr($this->humanizeAliasPlural($table->getAlias()), 0, self::$limit);
    }
}
