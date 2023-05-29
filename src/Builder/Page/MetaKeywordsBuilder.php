<?php

declare(strict_types=1);

namespace SeoBakery\Builder\Page;

use SeoBakery\Builder\Base\PageMetaBuilderBase;

class MetaKeywordsBuilder extends PageMetaBuilderBase
{
    protected static int $limit = 5;

    public function __invoke(string $template, string $action = 'view'): array
    {
        return $this->extractKeywordByOccurrence($this->humanizeAliasSingle($template), self::$limit);
    }
}
