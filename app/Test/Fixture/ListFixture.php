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
	public $import = array('model' => 'TodoList');


/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'hash' => '54fb62b0d48e5afc47d5',
			'public_hash' => 'be03765e8e5b8c8fdbe4',
			'name' => 'Nákup',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2012-04-15 18:15:40'
		),
		array(
			'id' => '2',
			'hash' => '74adfe744ae6353820ca',
			'public_hash' => 'a40c702b30a66d064189',
			'name' => 'Opravy',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2012-04-11 19:56:27'
		),
		array(
			'id' => '3',
			'hash' => 'a40c702b30asaaaaaa',
			'public_hash' => '54fb62b0d48bbbbbbb',
			'name' => 'Lorem ipsum',
			'created' => '2012-04-17 10:50:16',
			'modified' => '2012-04-17 10:50:16'
		),
	);
}
