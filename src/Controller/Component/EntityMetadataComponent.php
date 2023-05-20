<?php
declare(strict_types=1);

namespace SeoBakery\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Table;
use SeoBakery\Model\Behavior\MetadataBehavior;
use SeoBakery\Shared\SeoMetadataTableAware;

/**
 * EntityMetadata component
 */
class EntityMetadataComponent extends Component
{
    use SeoMetadataTableAware;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function beforeRender(EventInterface $event)
    {
        $seoMetadata = null;
        $isQualifyingRequest = $this->isQualifyingRequest();
        if ($isQualifyingRequest && $this->getConfig('model')) {
            $seoMetadata = $this->getBehaviorTable()->fetchMetaDataByRequest([
                'request' => $this->getRequest(),
            ]);
        }
        if ($seoMetadata) $this->getController()->set(compact('seoMetadata'));
    }

    protected function isQualifyingRequest(): bool
    {
        return
            $this->getConfig('prefix') === $this->getRequest()->getParam('prefix') &&
            $this->getConfig('plugin') === $this->getRequest()->getParam('plugin') &&
            $this->getConfig('controller') === $this->getRequest()->getParam('controller') &&
            in_array($this->getRequest()->getParam('action'), $this->getConfig('actions'));
    }

    /**
     * @return Table&MetadataBehavior
     */
    protected function getBehaviorTable(): Table
    {
        return $this->fetchTable($this->getConfig('model'));
    }

    /**
     * @return ServerRequest
     */
    protected function getRequest(): ServerRequest
    {
        return $this->getController()->getRequest();
    }
}
