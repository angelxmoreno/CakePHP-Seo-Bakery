<?php
declare(strict_types=1);

namespace SeoBakery\Builder\Entity;

use Cake\Datasource\EntityInterface;
use SeoBakery\Builder\Base\EntityMetaBuilderBase;

class MetaTitleBuilder extends EntityMetaBuilderBase
{
    protected static int $limit = 60;

    public function __invoke(EntityInterface $entity, string $action = 'view'): ?string
    {
        $title = $this->getEntityDisplayName($entity);
        if ($action <> 'view') {
            $title = ucfirst($action) . ' ' . $title;
        }
        return substr($title, 0, self::$limit);
    }
}
