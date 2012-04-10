<?php

namespace app\controllers;

use app\models\Lists;
use lithium\action\DispatchException;

class ListsController extends \lithium\action\Controller {

	public function index() {
		$lists = Lists::all();
		return compact('lists');
	}

	public function view() {
		$list = Lists::first(
			'first',
			array(
				'with' => 'Tasks',
				'conditions' => array(
					'Lists.id' => $this->request->id
				),
				'order' => 'Tasks.completed ASC, Tasks.completed_at DESC, Tasks.created DESC'
			)
		);
		return compact('list');
	}

	public function add() {
		$list = Lists::create();

		if (($this->request->data) && $list->save($this->request->data)) {
			return $this->redirect(array('Lists::view', 'args' => array($list->id)));
		}
		return compact('list');
	}

	public function edit() {
		$list = Lists::find($this->request->id);

		if (!$list) {
			return $this->redirect('Lists::index');
		}
		if (($this->request->data) && $list->save($this->request->data)) {
			return $this->redirect(array('Lists::view', 'args' => array($list->id)));
		}
		return compact('list');
	}

	public function delete() {
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			$msg = "Lists::delete can only be called with http:post or http:delete.";
			throw new DispatchException($msg);
		}
		Lists::find($this->request->id)->delete();
		return $this->redirect('Lists::index');
	}
}

?>