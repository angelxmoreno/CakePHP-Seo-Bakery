<?php
declare(strict_types=1);

namespace SeoBakery\Builder;

use Cake\Datasource\EntityInterface;
use SeoBakery\Shared\StopWords;

class SimpleMetaKeywordsBuilder extends SimpleMetaBuilderBase
{
    protected static int $limit = 5;

    public function __invoke(EntityInterface $entity, string $action = 'view'): array
    {
        $content = $this->getEntityDisplayName($entity);

        $descriptionBuilder = new SimpleMetaDescriptionBuilder($entity, $action);
        $content = $content . ' ' . $descriptionBuilder($entity, $action);

        $contentArray = explode(' ', $content);
        $uniqueContentArray = array_unique($contentArray);
        $uniqueContentArray = array_diff($uniqueContentArray, StopWords::STOP_WORDS);
        $wordCount = [];
        foreach ($uniqueContentArray as $word) {
            $wordCount[$word] = substr_count($content, $word);
        }
        arsort($wordCount, SORT_NUMERIC);
        $wordCount = array_splice($wordCount, 0, self::$limit);
        return array_keys($wordCount);
    }

}
