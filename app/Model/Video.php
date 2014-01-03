<?php
App::uses('AppModel', 'Model');
/**
 * Video Model
 *
 */
class Video extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'video_id';

  public function getAllFilenames() {
    $ret = array();
    $existing_videos = $this->find('all', array('fields' => array('file', 'dir')));
    
    foreach ($existing_videos as $v) {
      if (!array_key_exists($v['Video']['dir'], $ret)) {
        $ret[$v['Video']['dir']] = array();
      }
      $ret[$v['Video']['dir']][] = $v['Video']['file'];
    }
    
    return $ret;
  }

}
