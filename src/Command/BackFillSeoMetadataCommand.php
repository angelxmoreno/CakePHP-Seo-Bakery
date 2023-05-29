<?php

declare(strict_types=1);

namespace SeoBakery\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\CommandInterface;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;
use Cake\I18n\Number;
use Cake\ORM\Query;
use Cake\ORM\Table;
use SeoBakery\Model\Behavior\MetadataBehavior;
use SeoBakery\SeoBakeryPlugin;
use Throwable;

/**
 * BackFillSeoMetadata command.
 *
 * @property Arguments $args
 * @property ConsoleIo $io
 */
class BackFillSeoMetadataCommand extends Command
{
    use InstanceConfigTrait;

    public static function defaultName(): string
    {
        return 'seo:backfill';
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->setConfig(Configure::read(SeoBakeryPlugin::NAME));
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param ConsoleOptionParser $parser The parser to be defined
     * @return ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);
        $tableAliases = array_keys($this->getConfig('behaviorConfigs'));
        $tableAliases[] = 'all';
        $parser->setDescription('Creates SeoMetadata entries for entities');
        $parser->addArgument('tableAlias', [
            'help' => 'The table alias of a registered model or all.',
            'required' => true,
            'choices' => $tableAliases,
        ]);

        $parser->addOption('limit', [
            'short' => 'l',
            'help' => 'The size of each page while iterating',
            'default' => 50,
            'boolean' => false,
            'multiple' => false,
            'required' => false,
        ]);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param Arguments $args The command arguments.
     * @param ConsoleIo $io The console io
     * @return int The exit code
     */
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        try {
            $this->io = $io;
            $this->args = $args;
            $this->main();
            return CommandInterface::CODE_SUCCESS;
        } catch (Throwable $exception) {
            $io->error($exception->getMessage());
            debug($exception->getPrevious());
            $this->io->warning($exception->getTraceAsString());
        } finally {
            return CommandInterface::CODE_ERROR;
        }
    }

    protected function main()
    {
        $tableAlias = $this->args->getArgument('tableAlias');
        $tableAlias === 'all'
            ? $this->backFillAll()
            : $this->backFillModel($tableAlias);
    }

    protected function backFillAll()
    {
        $tableAliases = array_keys($this->getConfig('behaviorConfigs'));
        foreach ($tableAliases as $tableAlias) {
            $this->backFillModel($tableAlias);
        }
    }

    protected function backFillModel(string $tableAlias)
    {
        /** @var Table&MetadataBehavior $table */
        $table = $this->fetchTable($tableAlias);
        $query = $this->buildTableQuery($table);
        $count = $query->count();
        $limit = (int)$this->args->getOption('limit');
        $pages = ceil($count / $limit);
        $this->io->out(sprintf(
            'Found %s %s totaling %s pages',
            Number::format($count),
            $tableAlias,
            Number::format($pages),
        ));

        for ($page = 1; $page <= $pages; $page++) {
            $results = $query->cleanCopy()->page($page, $limit);
            foreach ($results as $index => $result) {
                $this->io->out("\t" . sprintf(
                    'Processing %s %s of %s: "%s"',
                    $tableAlias,
                    Number::format((($page - 1) * $limit) + $index + 1),
                    Number::format($count),
                    $result->get($table->getDisplayField())
                ));
                $table->buildMetadataActions($result);
            }
        }
    }

    protected function buildTableQuery(Table $table): Query
    {
        $conditions = $this->getConfig('backFill.' . $table->getAlias() . '.conditions');
        $finder = $this->getConfig('backFill.' . $table->getAlias() . '.finder', 'all');
        $options = $this->getConfig('backFill.' . $table->getAlias() . '.options', []);

        $query = $table->find($finder, $options);

        if ($conditions) {
            $query->where($conditions);
        }

        return $query;
    }
}
