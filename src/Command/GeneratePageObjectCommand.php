<?php

declare(strict_types=1);

namespace SeoBakery\Command;

use Bake\Command\SimpleBakeCommand;
use Cake\Console\Arguments;
use Cake\Console\ConsoleOptionParser;
use Cake\Utility\Inflector;

/**
 * GeneratePageObject command.
 */
class GeneratePageObjectCommand extends SimpleBakeCommand
{
    public function getOptionParser(): ConsoleOptionParser
    {
        $parser = parent::getOptionParser();
        $parser->addArgument('path', [
            'help' => 'The template path for the PageObject',
            'required' => false,
        ]);
        return $parser;
    }

    public $pathFragment = 'Seo/';

    public static function defaultName(): string
    {
        return 'seo:generate:pageObject';
    }

    /**
     * Get the generated object's name.
     *
     * @return string
     */
    public function name(): string
    {
        return 'SeoPageObject';
    }

    /**
     * Get the template name.
     *
     * @return string
     */
    public function template(): string
    {
        return 'SeoBakery.pageObject';
    }

    public function templateData(Arguments $arguments): array
    {
        $data = parent::templateData($arguments);
        $data['path'] = $arguments->getArgument('path') ?? '/' . Inflector::dasherize($arguments->getArgument('name'));
        return $data;
    }

    protected function generatePathFromName(string $name): string
    {
        return '/' . Inflector::dasherize($name);
    }

    /**
     * Get the generated object's filename without the leading path.
     *
     * @param string $name The name of the object being generated
     * @return string
     */
    public function fileName(string $name): string
    {
        return $name . 'PageObject.php';
    }
}
