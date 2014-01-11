<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

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
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
  public function beforeFilter() {
    parent::beforeFilter();
    // Allow users to register and logout.
    $this->Auth->allow('logout', 'oauth', 'oauth_callback');
    if ($this->Auth->user('user_id')) {
      $this->Auth->allow('*');
      $this->set('user', $this->Auth->user());
    }
  }
  
  public function login($msg = '') {
    
    $this->set('msg', $msg);
    
    if (is_array($this->Auth->user())) {
      header('Location: /video');
      exit;
    }

  }
  
  public function logout() {
      return $this->redirect($this->Auth->logout());
  }
  
  public function oauth() {
    require_once "../../.oauth_config.php";
    
    $url_params = http_build_query(
                                    array(
                                          'client_id'   => GGClientId, 
                                          'response_type' => 'code',
                                          'redirect_uri' => GGRedirectURIs,
                                          'scope' => 'openid email',
                                        )
                                  );
    //~ debug($url_params);exit;
    header('Location: https://accounts.google.com/o/oauth2/auth?'.$url_params);
    exit;
  }
  
  public function oauth_callback() {
    require_once "../../.oauth_config.php";
    require_once "../../lib/extra/JWT.php";
    
    $code_is = $this->request->query['code'];
    
    $cr = curl_init();
    curl_setopt_array($cr, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://accounts.google.com/o/oauth2/token',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array(
            'code' =>   $code_is,
            'client_id' => GGClientId,
            'client_secret' => GGClientSecret,
            'redirect_uri' => GGRedirectURIs,
            'grant_type' => 'authorization_code',
        )
    ));
    $res = curl_exec($cr);
    curl_close($cr);
        
    $token_obj = json_decode($res);
    $user_data = JWT::decode($token_obj->id_token, NULL, false);
    
    $udata = $this->User->find('first', 
                                  array(
                                    'conditions' => array('o.oauth_mail' => $user_data->email),
                                    'joins' => array(
                                                  array(
                                                    'alias' => 'o',
                                                    'table' => 'oauth_links',
                                                    'type' => 'LEFT',
                                                    'conditions' => 'o.user_id = User.user_id'
                                                  )
                                                ) 
                                  ) 
                              );
    
    $log_data = array(
                  
                );
    
    if (!empty($udata)) {
      if ($this->Auth->login($udata['User'])) {
        $log_data = array(
                      'user_id' => (int)$udata['User']['user_id'],
                      'controler' => 'users',
                      'action' => 'google login',
                      'description' => 'succesfull login from google - access_token: '. $user_data->email,
                      'ip' => $_SERVER['REMOTE_ADDR'],
                    );
        $log = new Log();
        $log->create();
        $log->save($log_data);
        return $this->redirect($this->Auth->redirect());
        exit;
      }
    }
    
    $log_data = array(
                  'user_id' => 0,
                  'controler' => 'users',
                  'action' => 'google login',
                  'description' => 'Wrong google login : '.$user_data->email,
                  'ip' => $_SERVER['REMOTE_ADDR'],
                );    
    $log = new Log();
    $log->create();
    $log->save($log_data);
    $this->redirect(
      array('controller' => 'users', 'action' => 'login', 'Cannot login - try again!')
    );
    exit;
  }
}

