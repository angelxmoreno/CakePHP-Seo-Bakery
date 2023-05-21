<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class DropedUris extends AbstractMigration
{
    public $autoId = false;

    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void
    {
        $this->table('seo_metadata')
            ->removeIndexByName('uri')
            ->update();

        $this->table('seo_metadata')
            ->removeColumn('uri')
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down(): void
    {

        $this->table('seo_metadata')
            ->addColumn('uri', 'string', [
                'after' => 'name',
                'default' => null,
                'length' => 500,
                'null' => true,
            ])
            ->addIndex(
                [
                    'uri',
                ],
                [
                    'name' => 'uri',
                    'unique' => true,
                ]
            )
            ->update();
    }
}
