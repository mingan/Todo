<?php
App::import('Lib', 'CacheDumper');

class DumpCacheShell extends AppShell {

	public function main () {
		$this->out('Dumping cache...');

		CacheDumper::dumpCache();

		$this->out('Cache dumped');
	}
}