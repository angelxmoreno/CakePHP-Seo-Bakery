<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class FallBackFields extends AbstractMigration
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
            ->addColumn('meta_title_fallback', 'string', [
                'after' => 'meta_title',
                'default' => null,
                'length' => 200,
                'null' => true,
            ])
            ->addColumn('meta_description_fallback', 'string', [
                'after' => 'meta_description',
                'default' => null,
                'length' => 200,
                'null' => true,
            ])
            ->addColumn('meta_keywords_fallback', 'text', [
                'after' => 'meta_keywords',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
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
            ->removeColumn('meta_title_fallback')
            ->removeColumn('meta_description_fallback')
            ->removeColumn('meta_keywords_fallback')
            ->update();
    }
}
