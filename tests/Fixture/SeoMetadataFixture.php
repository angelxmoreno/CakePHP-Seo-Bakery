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
                'url' => 'Lorem ipsum dolor sit amet',
                'canonical' => 'Lorem ipsum dolor sit amet',
                'entity_class' => 'Lorem ipsum dolor sit amet',
                'entity_identifier' => 1,
                'prefix' => 'Lorem ipsum dolor sit amet',
                'plugin' => 'Lorem ipsum dolor sit amet',
                'controller' => 'Lorem ipsum dolor sit amet',
                'action' => 'Lorem ipsum dolor sit amet',
                'passed' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'keywords' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'noindex' => 1,
                'nofollow' => 1,
                'created' => '2023-05-13 05:44:00',
                'modified' => '2023-05-13 05:44:00',
            ],
        ];
        parent::init();
    }
}
