<?php
App::uses('AppController', 'Controller');
/**
 * Lists Controller
 *
 * @property List $List
 */
class ListsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->List->recursive = 0;
		$this->set('lists', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->List->id = $id;
		if (!$this->List->exists()) {
			throw new NotFoundException(__('Invalid list'));
		}
		$this->set('list', $this->List->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->List->create();
			if ($this->List->save($this->request->data)) {
				$this->Session->setFlash(__('The list has been saved'));
				$this->redirect(array('action' => 'index'));
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
		$this->List->id = $id;
		if (!$this->List->exists()) {
			throw new NotFoundException(__('Invalid list'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->List->save($this->request->data)) {
				$this->Session->setFlash(__('The list has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The list could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->List->read(null, $id);
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
		$this->List->id = $id;
		if (!$this->List->exists()) {
			throw new NotFoundException(__('Invalid list'));
		}
		if ($this->List->delete()) {
			$this->Session->setFlash(__('List deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('List was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
