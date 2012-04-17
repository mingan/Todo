<?php
/**
 * ListFixture
 *
 */
class ListFixture extends CakeTestFixture {
/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'List');


/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'name' => 'Nákup',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2012-04-15 18:15:40',
			'id' => '1'
		),
		array(
			'name' => 'Opravy',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2012-04-11 19:56:27',
			'id' => '2'
		),
		array(
			'name' => 'Lorem ipsum',
			'created' => '2012-04-17 10:50:16',
			'modified' => '2012-04-17 10:50:16',
			'id' => '4'
		),
	);
}
