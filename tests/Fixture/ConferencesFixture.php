<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ConferencesFixture
 */
class ConferencesFixture extends TestFixture
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
                'edit_key' => 'Lorem ip',
                'title' => 'Lorem ipsum dolor sit amet',
                'start_date' => '2024-05-29',
                'end_date' => '2024-05-29',
                'institution' => 'Lorem ipsum dolor sit amet',
                'city' => 'Lorem ipsum dolor sit amet',
                'country' => 'Lorem ipsum dolor sit amet',
                'meeting_type' => 'Lorem ipsum dolor sit amet',
                'subject_area' => 'Lorem ipsum dolor sit amet',
                'homepage' => 'Lorem ipsum dolor sit amet',
                'contact_name' => 'Lorem ipsum dolor sit amet',
                'contact_email' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2024-05-29 02:21:25',
                'modified' => '2024-05-29 02:21:25',
            ],
        ];
        parent::init();
    }
}
