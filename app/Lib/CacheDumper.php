<?php
class CacheDumper {
	public static function dumpCache () {
		Cache::clear(false, 'default');
		Cache::clear(false, 'views');
		Cache::clear(false, '_cake_core_');
		Cache::clear(false, '_cake_model_');
		Cache::clear(false, 'less');
	}
}