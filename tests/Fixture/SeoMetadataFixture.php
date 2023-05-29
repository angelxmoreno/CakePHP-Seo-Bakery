<?php

declare(strict_types=1);

namespace SeoBakery\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SeoMetadataFixture
 */
class SeoMetadataFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'canonical' => 'Lorem ipsum dolor sit amet',
                'table_alias' => 'Lorem ipsum dolor sit amet',
                'table_identifier' => 1,
                'prefix' => 'Lorem ipsum dolor sit amet',
                'plugin' => 'Lorem ipsum dolor sit amet',
                'controller' => 'Lorem ipsum dolor sit amet',
                'action' => 'Lorem ipsum dolor sit amet',
                'passed' => json_encode(['0']),
                'meta_title' => 'Lorem ipsum dolor sit amet',
                'meta_title_fallback' => 'Lorem ipsum dolor sit amet',
                'meta_description' => 'Lorem ipsum dolor sit amet',
                'meta_description_fallback' => 'Lorem ipsum dolor sit amet',
                'meta_keywords' => json_encode(explode(' ', 'Lorem ipsum dolor sit amet, aliquet eerw')),
                'meta_keywords_fallback' => json_encode(explode(' ', 'Lorem ipsum dolor sit amet, qqe')),
                'noindex' => 1,
                'nofollow' => 1,
                'image_url' => 'https://example.com/image.png',
                'image_alt' => 'Some Image Alt',
                'created' => '2023-05-16 21:47:12',
                'modified' => '2023-05-16 21:47:12',
            ],
        ];
        parent::init();
    }
}
