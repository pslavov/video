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

  public function getList() {
    $ret = array();
    $existing_videos = $this->find('all', 
                          array(
                            'fields' => array('file', 'dir', 'ext', 'mime', 'mtime', 'size', 'video_id'),
                            'order' => 'mtime DESC',
                          )
                        );
    
    $vid_array = array();
    foreach ($existing_videos as $v) {
      if ($v['Video']['size'] < 20000000 or preg_match('/sample/i', $v['Video']['file'])) {
        continue;
      }
      
      if (!array_key_exists($v['Video']['dir'], $vid_array)) {
        $vid_array[$v['Video']['dir']] = array();
      }
      $data = $v['Video'];
      $data['mtime'] = strtotime($data['mtime']);
      $vid_array[$v['Video']['dir']][] = $data;
    }
    
    $vid_arr2 = array();
    $vid_arr2['Single'] = array();
    foreach ($vid_array AS $k => $v) {
      if (!array_key_exists($k, $vid_arr2)) {
        if (count($v) > 3) {
          $vid_arr2[$k] = $v;
        } else {
          $vid_arr2['Single'] = array_merge($vid_arr2['Single'], $v);
        }
      }
    }
    
    foreach ($vid_arr2 AS $k => $v) {
      $tmp_dir = preg_replace('#^'.$this->video_dir.'#', '', $k);
      if (strlen($tmp_dir) > 25 ) {
        $tmp_dir = substr($tmp_dir, 0, 28) . '..';
      } else if (strlen($tmp_dir) == 0) {
        $tmp_dir = 'Main';
      }

      $files = $v;
      if (in_array($tmp_dir, array('Main', 'Single'))) {
        uasort($files, array($this, 'video_compare'));
      } else {
        uasort($files, array($this, 'video_name_compare'));
      }
      $frst = current($files);
      $ret[$k] = $files;

      $ret[$k]['mtime'] = $frst['mtime'];
      $ret[$k]['count'] = count($files);
      $ret[$k]['video_dir'] = $tmp_dir;
    }
    
    uasort($ret, array($this, 'video_compare'));
    return $ret;
  }
  
  private function video_compare($a, $b) {
    if ($a['mtime'] == $b['mtime']) {
        return 0;
    }
    return ($a['mtime'] > $b['mtime']) ? -1 : 1;
  }
  
  private function video_name_compare($a, $b) {
    return strcmp($a['file'], $b['file']);
  }

  
  
}
