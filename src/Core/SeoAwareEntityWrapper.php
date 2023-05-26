<?php
declare(strict_types=1);

namespace SeoBakery\Core;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class SeoAwareEntityWrapper implements SeoAwareInterface
{
    use SeoAwareEntityTrait;

    protected EntityInterface $entity;
    protected Table $table;

    /**
     * @param EntityInterface $entity
     * @param Table|null $table
     */
    public function __construct(EntityInterface $entity, ?Table $table = null)
    {
        $this->entity = $entity;
        $this->table = $table ?? TableRegistry::getTableLocator()->get($entity->getSource());
    }

    protected function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    protected function getEntityTable(): Table
    {
        return $this->table;
    }
}
