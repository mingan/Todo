<?php
App::uses('SchemaShell', 'Console/Command');

class Schema2Shell extends SchemaShell {

/**
 * Run database create commands.  Alias for run create.
 *
 * @return void
 */
	public function latest () {
		$this->params['interactive'] = false;
		$this->_setLatestSnapshot();
		list($Schema, $table) = $this->_loadSchema();
		$this->_update($Schema, $table);
	}

/**
 * get the option parser
 *
 * @return void
 */
	public function getOptionParser() {
		$parser = parent::getOptionParser();

		$parser->addSubcommand('latest', array(
			'help' => __d('cake_console', 'Alter the tables based on the latest schema file.'),
			'parser' => array(
				'options' => compact('plugin', 'path', 'file', 'name', 'connection', 'dry', 'snapshot', 'force'),
				'args' => array(
					'name' => array(
						'help' => __d('cake_console', 'Name of schema to use.')
					),
					'table' => array(
						'help' => __d('cake_console', 'Only create the specified table.')
					)
				)
			)
		));
		return $parser;
	}

/**
 * Update database with Schema object
 * Should be called via the run method
 *
 * @param CakeSchema $Schema
 * @param string $table
 * @return void
 */
	protected function _update(&$Schema, $table = null) {
		$db = ConnectionManager::getDataSource($this->Schema->connection);

		$this->out(__d('cake_console', 'Comparing Database to Schema...'));
		$options = array();
		if (isset($this->params['force'])) {
			$options['models'] = false;
		}
		$Old = $this->Schema->read($options);
		$compare = $this->Schema->compare($Old, $Schema);

		$contents = array();

		if (empty($table)) {
			foreach ($compare as $table => $changes) {
				$contents[$table] = $db->alterSchema(array($table => $changes), $table);
			}
		} elseif (isset($compare[$table])) {
			$contents[$table] = $db->alterSchema(array($table => $compare[$table]), $table);
		}

		if (empty($contents)) {
			$this->out(__d('cake_console', 'Schema is up to date.'));
			$this->_stop();
		}

		$this->out("\n" . __d('cake_console', 'The following statements will run.'));
		$this->out(array_map('trim', $contents));
		if ((isset($this->params['interactive']) && !$this->params['interactive'])
				|| 'y' == $this->in(__d('cake_console', 'Are you sure you want to alter the tables?'), array('y', 'n'), 'n')) {
			$this->out();
			$this->out(__d('cake_console', 'Updating Database...'));
			$this->_run($contents, 'update', $Schema);
		}

		$this->out(__d('cake_console', 'End update.'));
	}

	public function _setLatestSnapshot () {
		$path = APP . 'Config' . DS . 'Schema';
		if (!empty($this->params['path'])) {
			$path = $this->params['path'];
		}

		$Folder = new Folder($path);
		$schemas = $Folder->find('schema(_\d+)?\.php');

		$latest = 0;
		foreach ($schemas as $schema) {
			$schema = (int)trim(trim($schema, '.php'), 'schema_');
			$latest = max($latest, $schema);
		}

		if ($latest) {
			$this->params['snapshot'] = $latest;
		}
	}
}