<?php
declare(strict_types=1);

namespace SeoBakery\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use SeoBakery\Model\Behavior\MetadataBehavior;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\SeoBakeryPlugin;
use SeoBakery\Shared\SeoMetadataAware;
use Throwable;

/**
 * Metadata component
 */
class MetadataComponent extends Component
{
    use SeoMetadataAware;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        $config = array_merge(Configure::read(SeoBakeryPlugin::NAME), $config);
        parent::__construct($registry, $config);
        $this->normalizeActionRules();
    }

    public function setActions(array $actions): void
    {
        $this->setConfig('actions', $actions, false);
        $this->normalizeActionRules();
    }

    public function startup(EventInterface $event)
    {
        $action = $this->getRequest()->getParam('action');
        $autoCreateActions = array_keys($this->getConfig('actions'));
        $autoCreate = in_array($action, $autoCreateActions);
        if ($autoCreate) {
            $seoMetadata = $this->createForAction($action);
            $this->getController()->set(compact('seoMetadata'));
            if ($seoMetadata->canonical && $seoMetadata->canonical <> $this->getRequest()->getRequestTarget()) {
                $this->getController()->redirect($seoMetadata->canonical, 301);
            }
        }
    }

    protected function createForAction(string $action): SeoMetadata
    {
        $tableName = Hash::get($this->getConfig('actions'), $action . '.table');
        $identifierFunc = Hash::get($this->getConfig('actions'), $action . '.identifier');
        $identifierFunc = is_callable($identifierFunc) ? $identifierFunc : fn(array $pass) => $pass[$identifierFunc];
        try {
            /** @var Table&MetadataBehavior $table */
            $table = $this->fetchTable($tableName);
            $id = $identifierFunc($this->getRequest()->getParam('pass'));
            $entity = $table->get($id);
            $seoMetadata = $table->buildMetadataFromEntity($entity);
        } catch (Throwable $exception) {
            $seoMetadata = $this->createMetadataFromRequest();
        }

        return $seoMetadata;
    }


    protected function getRequest(): ServerRequest
    {
        return $this->getController()->getRequest();
    }

    protected function normalizeActionRules(): void
    {
        $rules = [];
        $actions = $this->getConfig('actions');
        foreach ($actions as $action => $actionConfig) {
            if (is_string($actionConfig)) {
                $action = $actionConfig;
                $actionConfig = [];
            }

            $rules[$action] = array_merge([
                'table' => $this->getController()->getName(),
                'identifier' => 0,
            ], $actionConfig);
        }

        $this->setConfig('actions', $rules, false);
    }
}

