<?php

namespace app\models;

class Lists extends \lithium\data\Model {

	public $validates = array();

	public $hasMany = array('Tasks');
}

?>