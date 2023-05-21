<?php
declare(strict_types=1);

namespace SeoBakery\Builder\Page;

use SeoBakery\Builder\Base\PageMetaBuilderBase;

class MetaDescriptionBuilder extends PageMetaBuilderBase
{
    protected static int $limit = 160;

    public function __invoke(string $template, string $action = 'view'): string
    {
        $content = sprintf('The %s page', $this->humanizeAliasSingle($template));
        return substr($content, 0, self::$limit);
    }
}
