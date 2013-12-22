<?php
App::uses('AppController', 'Controller');
/**
 * OauthLinks Controller
 *
 * @property OauthLink $OauthLink
 * @property PaginatorComponent $Paginator
 */
class OauthLinksController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->OauthLink->recursive = 0;
		$this->set('oauthLinks', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OauthLink->exists($id)) {
			throw new NotFoundException(__('Invalid oauth link'));
		}
		$options = array('conditions' => array('OauthLink.' . $this->OauthLink->primaryKey => $id));
		$this->set('oauthLink', $this->OauthLink->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OauthLink->create();
			if ($this->OauthLink->save($this->request->data)) {
				return $this->flash(__('The oauth link has been saved.'), array('action' => 'index'));
			}
		}
		$users = $this->OauthLink->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->OauthLink->exists($id)) {
			throw new NotFoundException(__('Invalid oauth link'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OauthLink->save($this->request->data)) {
				return $this->flash(__('The oauth link has been saved.'), array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('OauthLink.' . $this->OauthLink->primaryKey => $id));
			$this->request->data = $this->OauthLink->find('first', $options);
		}
		$users = $this->OauthLink->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->OauthLink->id = $id;
		if (!$this->OauthLink->exists()) {
			throw new NotFoundException(__('Invalid oauth link'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->OauthLink->delete()) {
			return $this->flash(__('The oauth link has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The oauth link could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}}
