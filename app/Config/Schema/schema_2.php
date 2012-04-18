<?php 
class AppSchema extends CakeSchema {

	public $file = 'schema_2.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $lists = array(
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'hash' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
		'public_hash' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_czech_ci', 'engine' => 'InnoDB')
	);
	public $tasks = array(
		'list_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
		'desc' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
		'completed' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'completed_at' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'idx_tasks_list_id' => array('column' => 'list_id', 'unique' => 0), 'idx_tasks_completed_and_completed_at' => array('column' => array('completed', 'completed_at'), 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_czech_ci', 'engine' => 'InnoDB')
	);
}
