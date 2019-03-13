<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FileTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FileTable Test Case
 */
class FileTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FileTable
     */
    public $File;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.File',
        'app.Relates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('File') ? [] : ['className' => FileTable::class];
        $this->File = TableRegistry::getTableLocator()->get('File', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->File);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
