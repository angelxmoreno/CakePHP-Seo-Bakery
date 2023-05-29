<?php

declare(strict_types=1);

namespace SeoBakery\Command;

use Bake\Command\SimpleBakeCommand;

/**
 * GenerateListViewObject command.
 */
class GenerateListViewObjectCommand extends SimpleBakeCommand
{
    public $pathFragment = 'Seo/';

    public static function defaultName(): string
    {
        return 'seo:generate:listViewObject';
    }

    /**
     * Get the generated object's name.
     *
     * @return string
     */
    public function name(): string
    {
        return 'SeoListViewObject';
    }

    /**
     * Get the template name.
     *
     * @return string
     */
    public function template(): string
    {
        return 'SeoBakery.listViewObject';
    }

    /**
     * Get the generated object's filename without the leading path.
     *
     * @param string $name The name of the object being generated
     * @return string
     */
    public function fileName(string $name): string
    {
        return $name . 'ListViewObject.php';
    }
}
