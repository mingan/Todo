<?php
App::uses('TodoList', 'Model');

/**
 * TodoList Test Case
 *
 */
class TodoListTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.list', 'app.task');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TodoList = ClassRegistry::init('TodoList');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TodoList);

		parent::tearDown();
	}

/**
 * testGenerateHash method
 *
 * @return void
 */
	public function testGenerateHash() {
		$data = array(
			'TodoList' => array(
				'id' => null
			)
		);

		$result = $this->TodoList->generateHash($data);
		$expected = '';
		$this->assertTextNotEquals($expected, $result['TodoList']['hash']);
		$this->assertTextNotEquals($expected, $result['TodoList']['public_hash']);
		$this->assertTextNotEquals($result['TodoList']['hash'], $result['TodoList']['public_hash']);


		$data = array(
			'TodoList' => array(
				'id' => 1
			)
		);

		$result = $this->TodoList->generateHash($data);
		$expected = $data;
		$this->assertTextEquals($expected, $result);

	}
/**
 * testFilterTasks method
 *
 * @return void
 */
	public function testFilterTasks() {
		$data = array(
			'TodoList' => array()
		);

		$result = $this->TodoList->filterTasks($data);
		$expected = $data;
		$this->assertEqual($result, $expected);


		$data = array(
			'TodoList' => array(),
			'Task' => array(
				array(
					'id' => 1
				)
			)
		);

		$result = $this->TodoList->filterTasks($data);
		$expected = $data;
		unset($expected['Task'][0]);
		$this->assertEqual($result, $expected);


		$data = array(
			'TodoList' => array(),
			'Task' => array(
				array(
					'id' => 1,
					'name' => 'foo'
				)
			)
		);

		$result = $this->TodoList->filterTasks($data);
		$expected = $data;
		$this->assertEqual($result, $expected);

	}
/**
 * testFindWithTasks method
 *
 * @return void
 */
	public function testFindWithTasks() {

		$result = $this->TodoList->findWithTasks(array('id' => 2));
		$this->assertEqual($result['TodoList']['id'], 2);
		$this->assertEqual(sizeof($result['Task']), 2);
		$this->assertEqual($result['Task'][1]['id'], 35);

	}
}
