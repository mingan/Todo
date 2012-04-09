<?php

namespace app\models;

class Lists extends \li3_behaviors\extensions\Model {

    protected $_actsAs = array(
        'Dateable' => array(
			'autoIndex' => false,
			'updated' => array('field' => 'modified', 'auto' => true, 'format' => \DateTime::ISO8601),
		)
    );

	public $validates = array();

	public $hasMany = array('Tasks');
}

?>