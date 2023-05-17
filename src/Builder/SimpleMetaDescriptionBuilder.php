<?php
declare(strict_types=1);

namespace SeoBakery\Builder;

use Cake\Datasource\EntityInterface;

class SimpleMetaDescriptionBuilder extends SimpleMetaBuilderBase
{
    protected static int $limit = 160;

    public function __invoke(EntityInterface $entity, string $action = 'view')
    {
        $content = $entity->get('body');
        $content = $content ?? $entity->get('description');
        $content = $content ?? self::getEntityDisplayName($entity);
        if ($action <> 'view') {
            $content = ucfirst($action) . ' ' . $content;
        }

        return substr($content, 0, self::$limit);
    }
}
