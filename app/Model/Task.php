<?php
App::uses('AppModel', 'Model');
/**
 * Task Model
 *
 * @property List $List
 */
class Task extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'list_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'List' => array(
			'className' => 'List',
			'foreignKey' => 'list_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function beforeValidate($options = array()) {
		parent::beforeValidate($options);

		$this->data = $this->separateFields($this->data);

		return $this->data;
	}

	public function afterFind($results, $primary = false) {
		parent::afterFind($results, $primary);

		foreach ($results as &$r) {
			$r = $this->mergeFields($r);
			unset($r);
		}

		return $results;
	}


	public function separateFields ($data) {
		if (!isset($data['Task']['complete'])) {
			return $data;
		}

		$text = explode(PHP_EOL, $data['Task']['complete']);

		$data['Task']['name'] = trim(array_shift($text));
		$data['Task']['desc'] = implode(PHP_EOL, $text);

		return $data;
	}

	public function mergeFields ($data) {
		if (!empty($data['Task']['name']) && !empty($data['Task']['name'])) {
			$data['Task']['complete'] = trim($data['Task']['name'] . PHP_EOL . $data['Task']['desc'], PHP_EOL);
		} else {
			$data['Task']['complete'] = $data['Task']['name'];
		}

		return $data;
	}

	public function simple ($id) {
		return $this->find(
			'first',
			array(
				'conditions' => array('id' => $id),
				'recursive' => -1
			)
		);
	}
}
