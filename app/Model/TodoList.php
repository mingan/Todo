<?php
App::uses('AppModel', 'Model');
/**
 * List Model
 *
 * @property Task $Task
 */
class TodoList extends AppModel {
	public $name = 'List';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'list_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public $actsAs = array('Containable');

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		$options = array_merge(
			$options,
			array(
				'generateHash' => true
			)
		);

		if ($options['generateHash']) {
			$this->data = $this->generateHash($this->data);
		}

		return true;
	}

	public function generateHash ($data) {
		if (!(empty($data['TodoList']['id'])
				&& empty($data['TodoList']['hash'])
				&& empty($data['TodoList']['public_hash']))) {
			return $data;
		}

		do {
			$test = substr(sha1(rand() . serialize($data) . Configure::read('Security.salt')), 0, 20);
			$test2 = substr(sha1(serialize($data) . Configure::read('Security.salt') . rand()), 0, 20);
			$found = $this->find(
					'count',
					array(
						'conditions' => array(
							'OR' => array(
								'hash' => $test,
								'hash' => $test2,
								'public_hash' => $test,
								'public_hash' => $test2
							)
						),
						'recursive' => -1
					)
			);
		} while ($found);

		$data['TodoList']['hash'] = $test;
		$data['TodoList']['public_hash'] = $test2;

		return $data;
	}

	public function filterTasks ($data) {
		if (!isset($data['Task'])) {
			return $data;
		}

		$return = array();
		foreach ($data['Task'] as $task) {
			if ($this->Task->isSaveable($task)) {
				$return[] = $task;
			}

		}

		$data['Task'] = $return;
		return $data;
	}

	public function findWithTasks ($cond = array()) {
		return $this->find(
			'first',
			array(
				'conditions' => (array)$cond,
				'contain' => array(
					'Task' => array(
						'order' => 'completed ASC, completed_at DESC, created ASC',
					)
				)
			)
		);
	}
}
