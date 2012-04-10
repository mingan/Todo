<?php

namespace app\controllers;

use app\models\Tasks;
use lithium\action\DispatchException;

class TasksController extends \lithium\action\Controller {

	public function index() {
		$tasks = Tasks::all();
		return compact('tasks');
	}

	public function view() {
		$task = Tasks::first($this->request->id);
		return compact('task');
	}

	public function add() {
		$task = Tasks::create();

		if (($this->request->data) && $task->save($this->request->data)) {
			return $this->redirect($this->request->referer());
		}
		return compact('task');
	}

	public function edit() {
		$task = Tasks::find($this->request->id);

		if (!$task) {
			return $this->redirect($this->request->referer());
		}
		if (($this->request->data) && $task->save($this->request->data)) {
			return $this->redirect(array('Lists::view', 'args' => array($task->list_id)));
		}
		return compact('task');
	}

	public function completed () {
		$task = Tasks::find($this->request->id);

		if (!$task) {
			return $this->redirect($this->request->referer());
		}

		if ($task->save(array('completed' => true, 'completed_at' => date('c')))) {

		}
		return $this->redirect(array('Lists::view', 'args' => array($task->list_id)));
	}

	public function uncompleted () {
		$task = Tasks::find($this->request->id);

		if (!$task) {
			return $this->redirect($this->request->referer());
		}

		if ($task->save(array('completed' => false, 'completed_at' => null))) {

		}
		return $this->redirect(array('Lists::view', 'args' => array($task->list_id)));
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Tasks::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}

		Tasks::find($this->request->id)->delete();
		return $this->redirect($this->request->referer());
	}
}

?>