<?php
declare(strict_types=1);

namespace SeoBakery\Builder\Base;

use Cake\ORM\Table;

abstract class ListViewMetaBuilderBase extends MetaBuilderBase
{
    abstract public function __invoke(Table $table, string $action = 'view');
}
