<?php
declare(strict_types=1);

use Cake\Core\Configure;
use Cake\Event\EventManager;
use SeoBakery\Event\SeoBakeryListener;
use SeoBakery\SeoBakeryPlugin;

$configDefaults = [
    'backFill' => [],
    'behaviorModels' => [],
    'pages' => [],
];

$config = Configure::read(SeoBakeryPlugin::NAME, []);
$config = array_merge($configDefaults, $config);
$config['behaviorConfigs'] = SeoBakeryPlugin::buildBehaviorConfigs($config);
$config['entityComponentConfigs'] = SeoBakeryPlugin::buildEntityComponentConfigs($config['behaviorConfigs']);
$config['pagesComponentConfigs'] = SeoBakeryPlugin::buildPagesComponentConfigs($config['pages']);
Configure::write(SeoBakeryPlugin::NAME, $config);
$listener = new SeoBakeryListener($config);
EventManager::instance()->on($listener);
