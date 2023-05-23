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
        $name = $controller->getName();
        if ($controller->getPlugin() <> 'SeoBakery') {
            $controller->viewBuilder()->addHelper('SeoBakery.Metadata');
        }

        if ($name === 'Pages' && !empty($this->getConfig('pagesComponentConfigs'))) {
            $controller->loadComponent('SeoBakery.PagesMetadata', $this->getConfig('pagesComponentConfigs'));
        }

        if (array_key_exists($name, $this->getConfig('entityComponentConfigs'))) {
            $controller->loadComponent('SeoBakery.EntityMetadata', $this->getConfig('entityComponentConfigs')[$name]);
        }

        if (array_key_exists($name, $this->getConfig('listViewsComponentConfigs'))) {
            $controller->loadComponent('SeoBakery.ListViewMetadata', $this->getConfig('listViewsComponentConfigs')[$name]);
        }
    }
}
