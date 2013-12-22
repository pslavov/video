<?php
App::uses('AppModel', 'Model');
/**
 * OauthLink Model
 *
 * @property User $User
 */
class OauthLink extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'oauth_id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
