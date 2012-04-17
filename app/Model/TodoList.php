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
}
