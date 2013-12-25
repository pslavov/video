<?php
App::uses('AppController', 'Controller');
/**
 * Logs Controller
 *
 * @property Log $Log
 * @property PaginatorComponent $Paginator
 */
class VideoController extends AppController {

  public $uses = null;
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
    //
	}
  
  public function beforeFilter() {
    if ($this->Auth->user('user_id')) {
      $this->Auth->allow('index');
      $this->set('user', $this->Auth->user());
    }
  }

}
