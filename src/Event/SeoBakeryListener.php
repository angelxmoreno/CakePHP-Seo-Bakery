<?php

namespace SeoBakery\Event;

use Cake\Core\InstanceConfigTrait;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Table;

class SeoBakeryListener implements EventListenerInterface
{
    use InstanceConfigTrait;

    protected $_config = [];
    protected array $_defaultConfig = [];
    protected array $models = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);
        $this->models = $this->buildBehaviorModels();
    }

    public function implementedEvents(): array
    {
        return [
            'Model.initialize' => 'modelInitializeEvent',
        ];
    }

    public function modelInitializeEvent($event): void
    {
        /** @var Table $table */
        $table = $event->getSubject();
        $alias = $table->getAlias();

        if (in_array($alias, array_keys($this->models))) {
            $table->addBehavior('SeoBakery.Metadata', $this->models[$alias]);
        }
    }

    protected function buildBehaviorModels(): array
    {
        $models = [];
        $behaviorModels = $this->getConfig('behaviorModels');
        foreach ($behaviorModels as $k => $v) {
            $alias = is_string($v) ? $v : $k;
            $config = is_string($v) ? [] : $v;

            $models[$alias] = $config;
        }

        return $models;
    }
}
