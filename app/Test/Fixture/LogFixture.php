<?php
/**
 * LogFixture
 *
 */
class LogFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'log_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true),
		'controler' => array('type' => 'string', 'null' => true, 'length' => 64),
		'action' => array('type' => 'string', 'null' => true, 'length' => 64),
		'description' => array('type' => 'string', 'null' => true, 'length' => 1024),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'log_id')
		),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'log_id' => 1,
			'user_id' => 1,
			'controler' => 'Lorem ipsum dolor sit amet',
			'action' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet'
		),
	);

}
