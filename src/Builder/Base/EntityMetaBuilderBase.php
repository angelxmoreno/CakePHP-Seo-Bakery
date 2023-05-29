<?php

declare(strict_types=1);

namespace SeoBakery\Builder\Base;

use Cake\Datasource\EntityInterface;

abstract class EntityMetaBuilderBase extends MetaBuilderBase
{
    abstract public function __invoke(EntityInterface $entity, string $action = 'view');
}
