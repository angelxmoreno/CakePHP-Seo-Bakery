<?php

namespace SeoBakery\Core;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use SeoBakery\Builder\ListView;

abstract class SeoAwareListViewObject implements SeoAwareInterface
{
    /**
     * Returns the table name
     * i.e. `Products`, 'Articles`
     *
     * @return string
     */
    abstract protected function getTableName(): string;

    protected function getTable(): Table
    {
        return TableRegistry::getTableLocator()->get($this->getTableName());
    }

    public function buildMetaTitleFallback(string $action): string
    {
        $builder = new ListView\MetaTitleBuilder();
        return $builder($this->getTable(), $action);
    }

    public function buildMetaDescriptionFallback(string $action): string
    {
        $builder = new ListView\MetaDescriptionBuilder();
        return $builder($this->getTable(), $action);
    }

    public function buildMetaKeywordsFallback(string $action): array
    {
        $builder = new ListView\MetaKeywordsBuilder();
        return $builder($this->getTable(), $action);
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
            'controller' => $this->getTable()->getAlias(),
        ];
    }

    public function buildUrl(string $action): string
    {
        $url = $this->getPrefixPluginControllerArray() + [
                'action' => $action,
            ];
        return Router::url($url);
    }
}
