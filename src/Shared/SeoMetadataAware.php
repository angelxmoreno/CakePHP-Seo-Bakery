<?php
declare(strict_types=1);

namespace SeoBakery\Shared;

use Cake\Core\Exception\CakeException;
use Cake\Datasource\EntityInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;
use SeoBakery\Model\Behavior\MetadataBehavior;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Model\Table\SeoMetadataTable;

trait SeoMetadataAware
{
    use LocatorAwareTrait;

    public function createMetadataFromRequest(array $data = [], ?ServerRequest $request = null): SeoMetadata
    {
        return $this->getSeoMetadataTable()->findOrCreateByRequest($data, $request);
    }

    public function createMetadataFromEntity(EntityInterface $entity, array $data = []): SeoMetadata
    {
        $table = $this->getTableForEntity($entity);
        return $table->buildMetadataFromEntity($entity, $data);
    }

    /**
     * @return Table&MetadataBehavior
     */
    protected function getTableForEntity(EntityInterface $entity): Table
    {
        $table = $this->fetchTable($entity->getSource());
        if (!$table->hasBehavior('Metadata')) {
            throw new CakeException(sprintf(
                'Entity "%s" does not have the behavior "%s".',
                get_class($entity),
                MetadataBehavior::class
            ));
        }

        return $table;
    }

    /**
     * @return SeoMetadataTable|Table
     */
    protected function getSeoMetadataTable(): SeoMetadataTable
    {
        return $this->fetchTable(SeoMetadataTable::class);
    }
}
