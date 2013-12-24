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
