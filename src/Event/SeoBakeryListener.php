<?php

namespace SeoBakery\Event;

use Cake\Controller\Controller;
use Cake\Core\InstanceConfigTrait;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Table;
use Cake\Utility\Hash;
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

        if (in_array($alias, array_keys($this->getConfig('behaviorConfigs')))) {
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
        $name = $controller->getName();

        if (in_array($name, Hash::extract($this->getConfig('componentConfigs'), '{s}.controller'))) {
            $controller->loadComponent('SeoBakery.Metadata');
        }
    }
}
