<?php
declare(strict_types=1);

namespace SeoBakery\Builder\EntityAggregate;

use Cake\ORM\Association;
use Cake\ORM\Table;
use SeoBakery\Builder\Base\EntityAggregateMetaBuilderBase;

class MetaKeywordsBuilder extends EntityAggregateMetaBuilderBase
{
    protected static int $limit = 5;

    public function __invoke(Table $table, string $action = 'view'): array
    {
        $contentArray = [
            $this->humanizeAliasSingle($table->getAlias()),
        ];

        /** @var Association $association */
        foreach ($table->associations() as $association) {
            $contentArray[] = $this->humanizeAliasSingle($association->getName());
        }
        $content = implode(' ', $contentArray);
        return $this->extractKeywordByOccurrence($content, self::$limit);
    }

}
