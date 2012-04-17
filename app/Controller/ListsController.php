<?php
App::uses('AppController', 'Controller');
/**
 * Lists Controller
 *
 * @property List $List
 */
class ListsController extends AppController {
	public $uses = array('TodoList');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->TodoList->recursive = 0;
		$this->set('lists', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->TodoList->id = $id;
		if (!$this->TodoList->exists()) {
			throw new NotFoundException(__('Invalid list'));
		}
		$this->set('list', $this->TodoList->find(
			'first',
			array(
				'conditions' => array('id' => $id),
				'contain' => array(
					'Task' => array(
						'order' => 'completed ASC, completed_at DESC, created ASC',
					)
				)
			)
		));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TodoList->create();
			if ($this->TodoList->saveAll($this->TodoList->filterTasks($this->request->data))) {
				$this->Session->setFlash(__('The list has been saved'));
				$this->redirect(array('action' => 'view', $this->TodoList->id));
			} else {
				$this->Session->setFlash(__('The list could not be saved. Please, try again.'));
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
		$this->TodoList->id = $id;
		if (!$this->TodoList->exists()) {
			throw new NotFoundException(__('Invalid list'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TodoList->save($this->request->data)) {
				if ($this->RequestHandler->isAjax()) {
					$this->set('data', $this->request->data);
					$this->response->type('json');
					return $this->render('../Elements/json/default');
				}
				$this->Session->setFlash(__('The list has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The list could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TodoList->read(null, $id);
		}
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
		$this->TodoList->id = $id;
		if (!$this->TodoList->exists()) {
			throw new NotFoundException(__('Invalid list'));
		}
		if ($this->TodoList->delete()) {
			$this->Session->setFlash(__('List deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('List was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
