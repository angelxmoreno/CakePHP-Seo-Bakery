<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\Event\EventManager;
use SeoBakery\Event\SeoBakeryListener;
use SeoBakery\SeoBakeryPlugin;

$configDefaults = [
    'behaviorModels' => [],
];

$config = Configure::read(SeoBakeryPlugin::NAME, []);
$config = array_merge($configDefaults, $config);
$config['behaviorConfigs'] = SeoBakeryPlugin::buildBehaviorConfigs($config);
$config['componentConfigs'] = SeoBakeryPlugin::buildComponentConfigs($config['behaviorConfigs']);
Configure::write(SeoBakeryPlugin::NAME, $config);
$listener = new SeoBakeryListener($config);
EventManager::instance()->on($listener);
