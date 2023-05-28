<?php
declare(strict_types=1);

namespace SeoBakery\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use SeoBakery\SeoBakeryPlugin;

/**
 * Robots Controller
 *
 */
class RobotsController extends AppController
{
    public function display(): Response
    {
        $output = [];
        $config = Configure::read(SeoBakeryPlugin::NAME . '.robotRules', []);
        foreach ($config as $agent => $rules) {
            $disallows = Hash::get($rules, 'disallow', []);
            $allows = Hash::get($rules, 'allow', []);
            $output[] = sprintf('User-agent: %s', $agent);
            foreach ($disallows as $path) {
                $output[] = sprintf('Disallow: %s', $path);
            }
            foreach ($allows as $path) {
                $output[] = sprintf('Allow: %s', $path);
            }
            $output[] = "";
        }
        $output[] = sprintf('Sitemap: %s', Router::url(Configure::read(SeoBakeryPlugin::NAME . '.sitemapIndexPath'), true));

        return $this->getResponse()->withType('text')->withStringBody(implode("\n", $output));
    }
}
