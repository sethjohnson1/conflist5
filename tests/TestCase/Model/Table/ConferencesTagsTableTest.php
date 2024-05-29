<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConferencesTagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConferencesTagsTable Test Case
 */
class ConferencesTagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ConferencesTagsTable
     */
    protected $ConferencesTags;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ConferencesTags',
        'app.Conferences',
        'app.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ConferencesTags') ? [] : ['className' => ConferencesTagsTable::class];
        $this->ConferencesTags = $this->getTableLocator()->get('ConferencesTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ConferencesTags);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ConferencesTagsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ConferencesTagsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
