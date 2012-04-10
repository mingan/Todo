<?php
namespace app\extensions;

class Debugger extends \lithium\core\StaticObject {
	protected static $_sql = array();

	public static function add ($query, $time = 0) {
		static::$_sql[] = compact('query', 'time');
	}

	public static function dump () {
		return static::$_sql;
	}
}
