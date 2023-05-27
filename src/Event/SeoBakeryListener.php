<?php

namespace SeoBakery\Event;

use Cake\Controller\Controller;
use Cake\Core\InstanceConfigTrait;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Table;
use Exception;

class SeoBakeryListener implements EventListenerInterface
{
    use InstanceConfigTrait;

    protected $_config = [];
    protected array $_defaultConfig = [];
    protected array $models = [];
    protected array $controllers = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    public function implementedEvents(): array
    {
        return [
            'Model.initialize' => 'modelInitializeEvent',
            'Controller.initialize' => 'controllerInitializeEvent',
        ];
    }

    public function modelInitializeEvent($event): void
    {
        /** @var Table $table */
        $table = $event->getSubject();
        $alias = $table->getAlias();

        if (array_key_exists($alias, $this->getConfig('behaviorConfigs'))) {
            $table->addBehavior('SeoBakery.Metadata', $this->getConfig('behaviorConfigs')[$alias]);
        }
    }

    /**
     * @throws Exception
     */
    public function controllerInitializeEvent($event): void
    {
        /** @var Controller $controller */
        $controller = $event->getSubject();
        if ($controller->getPlugin() <> 'SeoBakery') {
            $controller->viewBuilder()->addHelper('SeoBakery.Metadata', $this->getConfig());
        }

        $controller->loadComponent('SeoBakery.Metadata');
    }
}
