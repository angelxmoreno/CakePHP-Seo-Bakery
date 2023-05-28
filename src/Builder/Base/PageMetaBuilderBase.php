<?php

declare(strict_types=1);

namespace SeoBakery\Builder\Base;

abstract class PageMetaBuilderBase extends MetaBuilderBase
{
    abstract public function __invoke(string $template, string $action = 'view');
}
