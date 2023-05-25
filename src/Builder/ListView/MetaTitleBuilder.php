<?php
declare(strict_types=1);

namespace SeoBakery\Builder\ListView;

use Cake\ORM\Table;
use SeoBakery\Builder\Base\ListViewMetaBuilderBase;

class MetaTitleBuilder extends ListViewMetaBuilderBase
{
    protected static int $limit = 60;

    public function __invoke(Table $table, string $action = 'view'): string
    {
        return substr($this->humanizeAliasPlural($table->getAlias()), 0, self::$limit);
    }
}
