<?php
App::uses('AppModel', 'Model');
/**
 * Log Model
 *
 */
class Log extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'log_id';

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
