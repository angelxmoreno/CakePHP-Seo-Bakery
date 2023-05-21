<?php
declare(strict_types=1);

namespace SeoBakery\Builder\Base;

use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use SeoBakery\Shared\StopWords;

abstract class MetaBuilderBase
{
    protected function getEntityDisplayName(EntityInterface $entity): ?string
    {
        $table = TableRegistry::getTableLocator()->get($entity->getSource());

        return !!$table ? $entity->get($table->getDisplayField()) : null;
    }

    protected function humanizeAliasSingle(string $alias): string
    {
        return Inflector::singularize($this->humanizeAlias($alias));
    }

    protected function humanizeAliasPlural(string $alias): string
    {
        return Inflector::pluralize($this->humanizeAlias($alias));
    }

    protected function humanizeAlias(string $alias): string
    {
        return Inflector::humanize(Inflector::underscore($alias));
    }

    protected function extractKeywordByOccurrence(string $content, int $size): array
    {
        $contentArray = explode(' ', $content);
        $uniqueContentArray = array_unique($contentArray);
        $uniqueContentArray = array_diff($uniqueContentArray, StopWords::STOP_WORDS);
        $wordCount = [];
        foreach ($uniqueContentArray as $word) {
            $wordCount[$word] = substr_count($content, $word);
        }
        arsort($wordCount, SORT_NUMERIC);
        $wordCount = array_splice($wordCount, 0, $size);
        return array_keys($wordCount);
    }
}
