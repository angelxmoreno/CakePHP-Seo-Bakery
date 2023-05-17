<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class NameChanges extends AbstractMigration
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
            ->removeIndexByName('url')
            ->removeIndexByName('entity_class')
            ->removeIndexByName('entity_identifier')
            ->update();

        $this->table('seo_metadata')
            ->removeColumn('url')
            ->removeColumn('entity_class')
            ->removeColumn('entity_identifier')
            ->removeColumn('title')
            ->removeColumn('description')
            ->removeColumn('keywords')
            ->changeColumn('passed', 'text', [
                'default' => null,
                'length' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('noindex', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('nofollow', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->update();
        $this->table('audits')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('session_uid', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('foreign_model_name', 'string', [
                'default' => '',
                'limit' => 200,
                'null' => true,
            ])
            ->addColumn('foreign_model_id', 'string', [
                'default' => '',
                'limit' => 200,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('action', 'string', [
                'default' => '',
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('diff', 'text', [
                'default' => null,
                'limit' => 4294967295,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->addIndex(
                [
                    'foreign_model_name',
                ]
            )
            ->addIndex(
                [
                    'foreign_model_id',
                ]
            )
            ->addIndex(
                [
                    'session_uid',
                ]
            )
            ->create();

        $this->table('brands')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('is_active', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('image_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('fragrance_count', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'image_id',
                ]
            )
            ->addIndex(
                [
                    'is_active',
                ]
            )
            ->create();

        $this->table('fnet_data_feeds')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('image_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('fnet_item_number', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('product_category', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('item_type', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('designer', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('brand_name', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('product_description', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('gender', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('scent_notes', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('year_introduced', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('recommended_use', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('retail_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 13,
                'scale' => 2,
                'signed' => false,
            ])
            ->addColumn('wholesale_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 13,
                'scale' => 2,
                'signed' => false,
            ])
            ->addColumn('image_url', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => '',
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('last_seen', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('brand_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('fragrance_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('suffix', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('size_in_ounces', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 6,
                'scale' => 2,
            ])
            ->addColumn('is_tester', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_set', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_mini', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'fnet_item_number',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'product_category',
                ]
            )
            ->addIndex(
                [
                    'item_type',
                ]
            )
            ->addIndex(
                [
                    'brand_id',
                ]
            )
            ->addIndex(
                [
                    'fragrance_id',
                ]
            )
            ->addIndex(
                [
                    'is_tester',
                ]
            )
            ->addIndex(
                [
                    'is_set',
                ]
            )
            ->addIndex(
                [
                    'size_in_ounces',
                ]
            )
            ->addIndex(
                [
                    'designer',
                ]
            )
            ->addIndex(
                [
                    'brand_name',
                ]
            )
            ->addIndex(
                [
                    'image_id',
                ]
            )
            ->create();

        $this->table('fnet_fragrances')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('fnet_item_number', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name_description', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('gender', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('retail_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 13,
                'scale' => 2,
            ])
            ->addColumn('cost', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 13,
                'scale' => 2,
            ])
            ->addColumn('fragrance_name', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('fragrance_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('suffix', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('size_in_ounces', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 6,
                'scale' => 2,
            ])
            ->addColumn('is_mini', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_tester', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_set', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('last_seen', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'fnet_item_number',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'gender',
                ]
            )
            ->addIndex(
                [
                    'fragrance_id',
                ]
            )
            ->addIndex(
                [
                    'is_set',
                ]
            )
            ->addIndex(
                [
                    'is_tester',
                ]
            )
            ->addIndex(
                [
                    'size_in_ounces',
                ]
            )
            ->addIndex(
                [
                    'fragrance_name',
                ]
            )
            ->create();

        $this->table('form_entries')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('body', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('uri', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('ip_address', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('host', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('user_agent', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ]
            )
            ->addIndex(
                [
                    'type',
                ]
            )
            ->create();

        $this->table('fragrances')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('brand_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('image_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('product_count', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'image_id',
                ]
            )
            ->addIndex(
                [
                    'brand_id',
                ]
            )
            ->addIndex(
                [
                    'is_active',
                ]
            )
            ->create();

        $this->table('images')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('image', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('dir', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('size', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('width', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('height', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('aspect_ratio', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('md5', 'char', [
                'default' => '',
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('jobs')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('queue', 'string', [
                'default' => null,
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('data', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('priority', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('expires_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('delay_until', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('locked', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('attempts', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created_at', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'queue',
                    'locked',
                ]
            )
            ->addIndex(
                [
                    'created_at',
                ]
            )
            ->create();

        $this->table('products')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('brand_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('fragrance_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('image_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('fnet_item_number', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('product_category', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('item_type', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 200,
                'null' => true,
            ])
            ->addColumn('scent_note_count', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('gender', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('year_introduced', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('recommended_use', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('retail_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 13,
                'scale' => 2,
                'signed' => false,
            ])
            ->addColumn('suffix', 'string', [
                'default' => null,
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => true,
            ])
            ->addColumn('size_in_ounces', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 6,
                'scale' => 2,
            ])
            ->addColumn('is_tester', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_set', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('in_stock', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'fnet_item_number',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'product_category',
                ]
            )
            ->addIndex(
                [
                    'item_type',
                ]
            )
            ->addIndex(
                [
                    'brand_id',
                ]
            )
            ->addIndex(
                [
                    'fragrance_id',
                ]
            )
            ->addIndex(
                [
                    'is_tester',
                ]
            )
            ->addIndex(
                [
                    'is_set',
                ]
            )
            ->addIndex(
                [
                    'size_in_ounces',
                ]
            )
            ->addIndex(
                [
                    'is_active',
                ]
            )
            ->create();

        $this->table('scent_notes')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('fragrance_count', 'integer', [
                'default' => '0',
                'limit' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('scent_notes_products')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('scent_note_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'scent_note_id',
                    'product_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'scent_note_id',
                ]
            )
            ->addIndex(
                [
                    'product_id',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('email', 'string', [
                'default' => '',
                'limit' => 200,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => '',
                'limit' => 200,
                'null' => true,
            ])
            ->addColumn('first_name', 'string', [
                'default' => '',
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => '',
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('role', 'string', [
                'default' => 'user',
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('activated', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'email',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'is_active',
                ]
            )
            ->addIndex(
                [
                    'role',
                ]
            )
            ->create();

        $this->table('vendor_prices')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('vendor_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('vendor_product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('cost_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 13,
                'scale' => 2,
                'signed' => false,
            ])
            ->addColumn('sale_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 13,
                'scale' => 2,
                'signed' => false,
            ])
            ->addColumn('in_stock', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('last_seen', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'vendor_id',
                    'product_id',
                    'last_seen',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'product_id',
                ]
            )
            ->addIndex(
                [
                    'last_seen',
                ]
            )
            ->addIndex(
                [
                    'vendor_id',
                ]
            )
            ->addIndex(
                [
                    'vendor_product_id',
                ]
            )
            ->create();

        $this->table('vendor_products')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 400,
                'null' => false,
            ])
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('vendor_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('vendor_uid', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'vendor_id',
                    'vendor_uid',
                    'product_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'product_id',
                ]
            )
            ->addIndex(
                [
                    'vendor_id',
                ]
            )
            ->addIndex(
                [
                    'vendor_uid',
                ]
            )
            ->create();

        $this->table('vendors')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('url', 'string', [
                'default' => '',
                'limit' => 250,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('seo_metadata')
            ->addColumn('name', 'string', [
                'after' => 'id',
                'default' => null,
                'length' => 500,
                'null' => false,
            ])
            ->addColumn('uri', 'string', [
                'after' => 'name',
                'default' => '',
                'length' => 500,
                'null' => false,
            ])
            ->addColumn('table_alias', 'string', [
                'after' => 'canonical',
                'default' => null,
                'length' => 100,
                'null' => true,
            ])
            ->addColumn('table_identifier', 'integer', [
                'after' => 'table_alias',
                'default' => null,
                'length' => null,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('meta_title', 'string', [
                'after' => 'passed',
                'default' => null,
                'length' => 200,
                'null' => true,
            ])
            ->addColumn('meta_description', 'string', [
                'after' => 'meta_title',
                'default' => null,
                'length' => 200,
                'null' => true,
            ])
            ->addColumn('meta_keywords', 'text', [
                'after' => 'meta_description',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ],
                [
                    'name' => 'name',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'uri',
                ],
                [
                    'name' => 'uri',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'table_alias',
                    'table_identifier',
                    'action',
                ],
                [
                    'name' => 'alias_identifier_action',
                ]
            )
            ->addIndex(
                [
                    'table_alias',
                ],
                [
                    'name' => 'table_alias',
                ]
            )
            ->addIndex(
                [
                    'table_identifier',
                ],
                [
                    'name' => 'table_identifier',
                ]
            )
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
            ->removeIndexByName('name')
            ->removeIndexByName('uri')
            ->removeIndexByName('alias_identifier_action')
            ->removeIndexByName('table_alias')
            ->removeIndexByName('table_identifier')
            ->update();

        $this->table('seo_metadata')
            ->addColumn('url', 'string', [
                'after' => 'id',
                'default' => '',
                'length' => 500,
                'null' => false,
            ])
            ->addColumn('entity_class', 'string', [
                'after' => 'canonical',
                'default' => null,
                'length' => 100,
                'null' => true,
            ])
            ->addColumn('entity_identifier', 'integer', [
                'after' => 'entity_class',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->addColumn('title', 'string', [
                'after' => 'passed',
                'default' => null,
                'length' => 200,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'after' => 'title',
                'default' => null,
                'length' => 200,
                'null' => true,
            ])
            ->addColumn('keywords', 'text', [
                'after' => 'description',
                'default' => null,
                'length' => null,
                'null' => true,
            ])
            ->changeColumn('passed', 'string', [
                'default' => null,
                'length' => 200,
                'null' => true,
            ])
            ->changeColumn('noindex', 'boolean', [
                'default' => '0',
                'length' => null,
                'null' => false,
            ])
            ->changeColumn('nofollow', 'boolean', [
                'default' => '0',
                'length' => null,
                'null' => true,
            ])
            ->removeColumn('name')
            ->removeColumn('uri')
            ->removeColumn('table_alias')
            ->removeColumn('table_identifier')
            ->removeColumn('meta_title')
            ->removeColumn('meta_description')
            ->removeColumn('meta_keywords')
            ->addIndex(
                [
                    'url',
                ],
                [
                    'name' => 'url',
                    'unique' => true,
                ]
            )
            ->addIndex(
                [
                    'entity_class',
                ],
                [
                    'name' => 'entity_class',
                ]
            )
            ->addIndex(
                [
                    'entity_identifier',
                ],
                [
                    'name' => 'entity_identifier',
                ]
            )
            ->update();

        $this->table('audits')->drop()->save();
        $this->table('brands')->drop()->save();
        $this->table('fnet_data_feeds')->drop()->save();
        $this->table('fnet_fragrances')->drop()->save();
        $this->table('form_entries')->drop()->save();
        $this->table('fragrances')->drop()->save();
        $this->table('images')->drop()->save();
        $this->table('jobs')->drop()->save();
        $this->table('products')->drop()->save();
        $this->table('scent_notes')->drop()->save();
        $this->table('scent_notes_products')->drop()->save();
        $this->table('users')->drop()->save();
        $this->table('vendor_prices')->drop()->save();
        $this->table('vendor_products')->drop()->save();
        $this->table('vendors')->drop()->save();
    }
}
