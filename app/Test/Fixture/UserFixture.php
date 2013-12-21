<?php
/**
 * UserFixture
 *
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'username' => array('type' => 'string', 'null' => true, 'length' => 128),
		'name' => array('type' => 'string', 'null' => true),
		'created_at' => array('type' => 'datetime', 'null' => true, 'default' => 'now()'),
		'is_active' => array('type' => 'boolean', 'null' => true, 'default' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'user_id')
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
			'user_id' => 1,
			'username' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'created_at' => '2013-12-21 23:38:17',
			'is_active' => 1
		),
	);

}
