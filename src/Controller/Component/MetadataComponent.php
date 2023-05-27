<?php
declare(strict_types=1);

namespace SeoBakery\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\EventInterface;
use Cake\Http\ServerRequest;
use SeoBakery\Core\SeoAwareRegistry;
use SeoBakery\Shared\SeoMetadataTableAware;

/**
 * Metadata component
 */
class MetadataComponent extends Component
{
    use SeoMetadataTableAware;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function initialize(array $config): void
    {
        parent::initialize($config);
        SeoAwareRegistry::scan();
    }

    public function beforeRender(EventInterface $event)
    {
        $controller = $this->getController();
        $path = $this->getRequest()->getUri()->getPath();
        $seoMetadata = SeoAwareRegistry::getFromRequest($this->getRequest());

        if ($seoMetadata) {
            if ($seoMetadata->canonical && $path <> $seoMetadata->canonical) {
                return $controller->redirect($this->getRequest()->getUri()->withPath($seoMetadata->canonical));
            }
            $controller->set('seoMetadata', $seoMetadata);
        }
    }

    /**
     * @return ServerRequest
     */
    protected function getRequest(): ServerRequest
    {
        return $this->getController()->getRequest();
    }
}
