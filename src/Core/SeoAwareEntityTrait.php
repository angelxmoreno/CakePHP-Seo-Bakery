<?php

declare(strict_types=1);

namespace SeoBakery\Core;

use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use SeoBakery\Builder\Entity;

trait SeoAwareEntityTrait
{
    public function buildMetaTitleFallback(string $action): string
    {
        $builder = new Entity\MetaTitleBuilder();
        return $builder($this->getEntity(), $action);
    }

    public function buildMetaDescriptionFallback(string $action): string
    {
        $builder = new Entity\MetaDescriptionBuilder();
        return $builder($this->getEntity(), $action);
    }

    public function buildMetaKeywordsFallback(string $action): array
    {
        $builder = new Entity\MetaKeywordsBuilder();
        return $builder($this->getEntity(), $action);
    }

    public function buildRobotsShouldIndex(string $action): bool
    {
        return true;
    }

    public function buildRobotsShouldFollow(string $action): bool
    {
        return true;
    }

    public function getPrefixPluginControllerArray(): array
    {
        return [
            'prefix' => false,
            'plugin' => false,
            'controller' => $this->getEntityTable()->getAlias(),
        ];
    }

    public function buildUrl(string $action): string
    {
        $url = $this->getPrefixPluginControllerArray() + [
                'action' => $action,
                $this->getPrimaryKeyValue(),
            ];
        return Router::url($url);
    }

    /**
     * @return EntityInterface|SeoAwareEntityTrait
     */
    protected function getEntity(): EntityInterface
    {
        return $this;
    }

    public function getEntityTable(): Table
    {
        return TableRegistry::getTableLocator()->get($this->getEntity()->getSource());
    }

    public function getPrimaryKeyValue()
    {
        return $this->getEntity()->get($this->getEntityTable()->getPrimaryKey());
    }

    public function buildImageUrl(string $action): ?string
    {
        return null;
    }

    public function buildImageAlt(string $action): ?string
    {
        return null;
    }

    public function buildSeoName(string $action): string
    {
        return implode(':', [
            $this->getEntityTable()->getAlias(),
            $action,
            $this->getPrimaryKeyValue(),
        ]);
    }

    public function actions(): array
    {
        return ['view'];
    }
}
