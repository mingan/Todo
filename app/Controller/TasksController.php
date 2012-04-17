<?php
App::uses('AppController', 'Controller');
/**
 * Tasks Controller
 *
 * @property Task $Task
 */
class TasksController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Task->recursive = 0;
		$this->set('tasks', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		$this->set('task', $this->Task->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Task->create();
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			return $this->redirect($this->request->referer());
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Task->save($this->request->data)) {
				if ($this->RequestHandler->isAjax()) {
					$this->set('data', $this->Task->simple($id));
					$this->response->type('json');
					return $this->render('../Elements/json/default');
				}
				$this->Session->setFlash(__('The task has been saved'));
				//return $this->redirect(array('view', $task['Task']['id']));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Task->simple($id);

			if ($this->RequestHandler->isAjax()) {
				$this->layout = 'ajax';
			}
		}
	}

	public function complete ($id) {
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			$this->Session->setFlash(__('Invalid task'));
			return $this->redirect($this->request->referer());
		}

		$task = $this->Task->read();

		if ($task = $this->Task->save(array('completed' => true, 'completed_at' => date('c')))) {
			if ($this->RequestHandler->isAjax()) {
				$this->set('data', $task);
				return $this->render('../Elements/json/default');
			}
		}

		return $this->redirect(array('view', $task['Task']['id']));
	}

	public function uncomplete ($id) {
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			$this->Session->setFlash(__('Invalid task'));
			return $this->redirect($this->request->referer());
		}

		$task = $this->Task->read();

		if ($task = $this->Task->save(array('completed' => false, 'completed_at' => null))) {
			if ($this->RequestHandler->isAjax()) {
				$this->set('data', $task);
				return $this->render('../Elements/json/default');
			}
		}
		return $this->redirect(array('view', $task['Task']['id']));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->Task->delete()) {
			$this->Session->setFlash(__('Task deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Task was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
