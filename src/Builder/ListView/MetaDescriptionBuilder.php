<?php

declare(strict_types=1);

namespace SeoBakery\Builder\ListView;

use Cake\ORM\Association;
use Cake\ORM\Table;
use SeoBakery\Builder\Base\ListViewMetaBuilderBase;

class MetaDescriptionBuilder extends ListViewMetaBuilderBase
{
    protected static int $limit = 160;

    public function __invoke(Table $table, string $action = 'view'): string
    {
        $content = [];
        $last = null;

        /** @var Association $association */
        foreach ($table->associations() as $association) {
            $content[] = $this->humanizeAliasPlural($association->getName());
        }
        if (!empty($content)) {
            $last = ' and ' . array_pop($content);
        }
        array_unshift($content, 'List of ' . $this->humanizeAliasPlural($table->getAlias()));
        $content = implode(', ', $content) . $last;
        return substr($content, 0, self::$limit);
    }
}
