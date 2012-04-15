<?php

namespace app\tests\cases\models;

use li3_fixtures\test\Fixture;
use app\models\Tasks;

class TasksTest extends \lithium\test\Unit {

	public function setUp() {

	}

	public function tearDown() {}

	public function testMergeFields () {
		$fixtures = Fixture::load('Task');

		$fixture = $fixtures->first();
		$task = Tasks::create($fixture);

		$expected= $fixture['name'] . "\n" . $fixture['desc'];
		$this->assertEqual($expected, $task->mergeFields()->desc);

		$fixture = $fixtures['taskNoDesc'];
		$task = Tasks::create($fixture);

		$expected= $fixture['name'];
		$this->assertEqual($expected, $task->mergeFields()->desc);
	}

	public function testSeparateNameAndDesc () {
		$fixtures = Fixture::load('Task');

		$data = array(
			'desc' => 'name' . "\n" . 'desc'
		);
		$expected = array(
			'name' => 'name',
			'desc' => 'desc'
		);
		$this->assertEqual($expected, Tasks::_separateNameAndDesc($data));

		$data = array(
			'desc' => 'name'
		);
		$expected = array(
			'name' => 'name',
			'desc' => ''
		);
		$this->assertEqual($expected, Tasks::_separateNameAndDesc($data));

		$data = array(
			'name' => 'name'
		);
		$expected = array(
			'name' => 'name',
		);
		$this->assertEqual($expected, Tasks::_separateNameAndDesc($data));
	}

}

?>