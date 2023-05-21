<?php
declare(strict_types=1);

namespace SeoBakery\Builder\Entity;

use Cake\Datasource\EntityInterface;
use SeoBakery\Builder\Base\EntityMetaBuilderBase;

class MetaTitle extends EntityMetaBuilderBase
{
    protected static int $limit = 60;

    public function __invoke(EntityInterface $entity, string $action = 'view')
    {
        $title = $this->getEntityDisplayName($entity);
        if ($action <> 'view') {
            $title = ucfirst($action) . ' MetaTitle.php' . $title;
        }
        return substr($title, 0, self::$limit);
    }
}
