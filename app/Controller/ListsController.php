<?php
App::uses('AppController', 'Controller');
/**
 * Lists Controller
 *
 * @property List $List
 */
class ListsController extends AppController {
	public $uses = array('TodoList');
	public $helpers = array('Cache');
	public $cacheAction = array(
		'share' => 1800
	);

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
	public function share($hash = null) {var_dump(rand());
		$list = $this->TodoList->findWithTasks(array('public_hash' => $hash));
		if (empty($list)) {
			throw new NotFoundException(__('Invalid list'));
		}
		$private = false;
		$this->set(compact('list', 'private'));
		$this->render('view');
	}

	public function view($hash = null) {
		$list = $this->TodoList->findWithTasks(array('hash' => $hash));
		if (empty($list)) {
			throw new NotFoundException(__('Invalid list'));
		}
		$private = true;
		$this->set(compact('list', 'private'));
		$this->render('view');
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
				$this->redirect(array('action' => 'view', $this->TodoList->field('hash')));
			} else {
				$this->Session->setFlash(__('The list could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $hash
 * @return void
 */
	public function edit($hash = null) {
		$list = $this->TodoList->findByHash($hash);
		if (empty($list)) {
			throw new NotFoundException(__('Invalid list'));
		}
		$this->request->data['TodoList']['id'] = $list['TodoList']['id'];
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TodoList->save($this->request->data)) {
				if ($this->RequestHandler->isAjax()) {
					$this->set('data', $this->request->data);
					$this->response->type('json');
					return $this->render('../Elements/json/default');
				}
				$this->Session->setFlash(__('The list has been saved'));
				$this->redirect(array('action' => 'view', $list['TodoList']['hash']));
			} else {
				$this->Session->setFlash(__('The list could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $list;
		}
	}

}
