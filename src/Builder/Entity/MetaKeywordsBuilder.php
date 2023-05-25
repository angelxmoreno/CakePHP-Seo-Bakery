<?php
declare(strict_types=1);

namespace SeoBakery\Builder\Entity;

use Cake\Datasource\EntityInterface;
use SeoBakery\Builder\Base\EntityMetaBuilderBase;

class MetaKeywordsBuilder extends EntityMetaBuilderBase
{
    protected static int $limit = 5;

    public function __invoke(EntityInterface $entity, string $action = 'view'): array
    {
        $content = $this->getEntityDisplayName($entity);
        $descriptionBuilder = new MetaDescriptionBuilder();
        $content = $content . ' ' . $descriptionBuilder($entity, $action);
        return $this->extractKeywordByOccurrence($content, self::$limit);
    }

}
