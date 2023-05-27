<?php
declare(strict_types=1);

namespace SeoBakery\Builder\Page;

use SeoBakery\Builder\Base\PageMetaBuilderBase;

class MetaTitleBuilder extends PageMetaBuilderBase
{
    protected static int $limit = 60;

    public function __invoke(string $template, string $action = 'view'): string
    {
        return substr($this->humanizeAliasSingle($template), 0, self::$limit);
    }
}
