<?php
App::uses('Task', 'Model');

/**
 * Task Test Case
 *
 */
class TaskTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.task', 'app.list');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Task = ClassRegistry::init('Task');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Task);

		parent::tearDown();
	}

/**
 * testGetList method
 *
 * @return void
 */
	public function testGetList() {
		$data = array(
			'Task' => array(
				'list_id' => 1
			)
		);
		$result = $this->Task->getList($data);
		$this->assertEqual($result, $data);

		$data = array(
			'Task' => array(
				'list_hash' => null
			)
		);
		$result = $this->Task->getList($data);
		$this->assertEqual($result, $data);

		$data = array(
			'Task' => array(
				'list_hash' => '54fb62b0d48e5afc47d5'
			)
		);
		$result = $this->Task->getList($data);
		$expected = $data;
		$expected['Task']['list_id'] = 1;
		$this->assertEqual($result, $expected);

	}
/**
 * testSeparateFields method
 *
 * @return void
 */
	public function testSeparateFields() {
		$data = array(
			'Task' => array(
			)
		);
		$result = $this->Task->separateFields($data);
		$this->assertEqual($result, $data);

		$data = array(
			'Task' => array(
				'complete' => 'Ví po 11 přidat šlechta paprikové?'
			)
		);
		$result = $this->Task->separateFields($data);
		$expected = $data;
		$expected['Task']['name'] = 'Ví po 11 přidat šlechta paprikové?';
		$expected['Task']['desc'] = null;
		$this->assertEqual($result, $expected);

		$data = array(
			'Task' => array(
				'complete' => 'Ví po 11 přidat šlechta paprikové?
Hm au pojistil vzaly. Ba tmě důvěrný tento, si droboučká k běhal ni syna pletli projít k klíče. Ex müller trému smyslné. Zašil on vitamíny u hovořil zaměstnání.'
			)
		);
		$result = $this->Task->separateFields($data);
		$expected = $data;
		$expected['Task']['name'] = 'Ví po 11 přidat šlechta paprikové?';
		$expected['Task']['desc'] = 'Hm au pojistil vzaly. Ba tmě důvěrný tento, si droboučká k běhal ni syna pletli projít k klíče. Ex müller trému smyslné. Zašil on vitamíny u hovořil zaměstnání.';

		$this->assertEqual($result, $expected);
	}
/**
 * testMergeFields method
 *
 * @return void
 */
	public function testMergeFields() {
		$data = array(
			'Task' => array(
				'name' => 'foo',
				'desc' => null
			)
		);
		$result = $this->Task->mergeFields($data);
		$expected = $data;
		$expected['Task']['complete'] = 'foo';
		$this->assertEqual($result, $expected);

		$fixture = new TaskFixture();
		$data = array('Task' => $fixture->records[0]);
		$result = $this->Task->mergeFields($data);
		$expected = $data;
		$expected['Task']['complete'] = $expected['Task']['name'] . PHP_EOL . $expected['Task']['desc'];
		$this->assertEqual($result, $expected);
	}
/**
 * testSimple method
 *
 * @return void
 */
	public function testSimple() {
		$fixture = new TaskFixture();
		$data = array('Task' => $fixture->records[0]);

		$result = $this->Task->simple($data['Task']['id']);
		$expected = $data;
		$this->assertEqual($result['Task']['name'], $expected['Task']['name']);
	}
/**
 * testIsSaveable method
 *
 * @return void
 */
	public function testIsSaveable() {
		$data = array();

		$result = $this->Task->isSaveable($data);
		$expected = false;
		$this->assertEqual($result, $expected);

		$data = array(
			'name' => 'foo'
		);
		$result = $this->Task->isSaveable($data);
		$expected = true;
		$this->assertEqual($result, $expected);

		$data = array(
			'complete' => 'foo'
		);
		$result = $this->Task->isSaveable($data);
		$expected = true;
		$this->assertEqual($result, $expected);

		$data = array(
			'Task' => array(
				'complete' => 'foo'
			)
		);
		$result = $this->Task->isSaveable($data);
		$expected = true;
		$this->assertEqual($result, $expected);


	}
}
