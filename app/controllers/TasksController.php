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

		if ($this->request->is('ajax')) {
			$this->_render['layout'] = 'ajax';
		}

		if (($this->request->data) && $task->save($this->request->data)) {
			if ($this->request->is('ajax')) {
				return $this->render(array(
					'data' => array('task' => $task),
					'type' => 'html',
					'template' => 'view'
				));
			}
			return $this->redirect(array('Lists::view', 'args' => array($task->list_id)));
		}
		return compact('task');
	}

	public function edit() {
		$task = Tasks::find($this->request->id);

		if (!$task) {
			return $this->redirect($this->request->referer());
		}

		if (($this->request->data)) {
			if ($task->save($this->request->data)) {
				if ($this->request->is('ajax')) {
					return $this->render(array(
						'data' => $task->to('array'),
						'type' => 'json',
					));
				}
				return $this->redirect(array('Lists::view', 'args' => array($task->list_id)));
			}
		} else {
			if ($this->request->is('ajax')) {
				$this->_render['layout'] = 'ajax';
			}
			$task->mergeFields();
		}
		return compact('task');
	}

	public function complete () {
		$task = Tasks::find($this->request->id);

		if (!$task) {
			return $this->redirect($this->request->referer());
		}

		if ($task->save(array('completed' => true, 'completed_at' => date('c')))) {
			if ($this->request->type() == 'json') {
				return array('data' => $task);
			}
		}

		return $this->redirect(array('Lists::view', 'args' => array($task->list_id)));
	}

	public function uncomplete () {
		$task = Tasks::find($this->request->id);

		if (!$task) {
			return $this->redirect($this->request->referer());
		}

		if ($task->save(array('completed' => false, 'completed_at' => null))) {
			if ($this->request->type() == 'json') {
				return array('data' => $task);
			}
		}
		return $this->redirect(array('Lists::view', 'args' => array($task->list_id)));
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Tasks::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}

		if (Tasks::find($this->request->id)->delete()) {
			if ($this->request->is('ajax')) {
				return $this->render(array(
					'data' => array('deleted' => true),
					'type' => 'json'
				));
			}
		}
		return $this->redirect($this->request->referer());
	}
}

?>