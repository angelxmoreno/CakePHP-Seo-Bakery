<?php
declare(strict_types=1);

namespace SeoBakery\Builder;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

abstract class SimpleMetaBuilderBase
{
    abstract public function __invoke(EntityInterface $entity, string $action = 'view');

    protected function getEntityDisplayName(EntityInterface $entity): ?string
    {
        $table = TableRegistry::getTableLocator()->get($entity->getSource());

        return !!$table ? $entity->get($table->getDisplayField()) : null;
    }
}
