<?php
App::uses('AppController', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Logs Controller
 *
 * @property Log $Log
 * @property PaginatorComponent $Paginator
 */
class VideosController extends AppController {

  public $uses = array('Log', 'Video');
	public $components = array('Paginator');
  private $video_dir = "/disk2/data";

/**
 * index method
 *
 * @return void
 */
	public function index($dir = '') {
    //
    require_once '../../.local_user.php';
    
    $this->scanDir();
    $this->Video->video_dir = $this->video_dir;
    $videos = $this->Video->getList();
    if (empty($dir)) {
      $tmp_v = current($videos);
      $dir = $tmp_v['video_dir'];
    } else {
      $dir = urldecode($dir);
    }
    
    $this->set('vids', $videos);
    $this->set('dir', $dir);
    $this->set('luser', luser);
    $this->set('lpwd', lpwd);
    $this->set('video_dir', $this->video_dir);
  }
  
  private function scanDir() {
    
    $Iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->video_dir));
    //~ $Regex = new RegexIterator($Iterator, '/^.+\.(avi|mkv|mp4|flv|mpg|mpeg|mov)$/i', RecursiveRegexIterator::GET_MATCH);
    
    $existing_videos = $this->Video->getAllFilenames();
    
    
    
    $pattern = '/^(avi|mkv|mp4|flv|mpg|mpeg|mov)$/i';
    $all_fl_info = array();
    foreach ($Iterator as $f) {
      if (preg_match($pattern, $f->getExtension())) {
        $full_path = $f->getPath() . '/' . $f->getFilename();
        $create_new = True;
        if (array_key_exists($f->getPath(), $existing_videos)) {
          if (in_array($f->getFilename(), $existing_videos[$f->getPath()])) {
            $create_new = False;
          } 
        }
          
        if ($create_new) {      
            
            $meta = $this->getMetaData($full_path);
            
            $data = array('file' => $f->getFilename(),
                          'dir' => $f->getPath(),
                          'ext' => $f->getExtension(),
                          'mtime' => date("Y-m-d H:i:s", $f->getMTime()),
                          'size' => $meta['filesize'],
                          'processed' => True,
                          'mime' => $meta['mime'],
                          'duration' => $meta['duration'],
                          'width' => $meta['resolution_x'],
                          'height' => $meta['resolution_y'],
                          'mime' => $meta['mime'],
                    );
            $this->Video->create();
            $this->Video->save($data);
            
            $log_data = array(
                  'user_id' => (int)$this->Auth->user('user_id'),
                  'controler' => 'videos',
                  'action' => 'add new',
                  'description' => 'Added new video: '.$full_path,
                  'ip' => $_SERVER['REMOTE_ADDR'],
                );    
            $this->Log->create();
            $this->Log->save($log_data);
          
        } 
      }
    }
    
    //~ debug($i);
    
    unset($Iterator);
    
    foreach ($existing_videos AS $d => $vfiles) {
      if (is_array($vfiles)) {
        foreach ($vfiles AS $id => $f) {
          $full_path = $d .'/'.$f;
          if (!file_exists($full_path)) {
            
            if ($del = $this->Video->delete($id)) {
            
              $log_data = array(
                    'user_id' => (int)$this->Auth->user('user_id'),
                    'controler' => 'videos',
                    'action' => 'add new',
                    'description' => 'Removed old video: '.$full_path,
                    'ip' => $_SERVER['REMOTE_ADDR'],
                  );    
              $this->Log->create();
              $this->Log->save($log_data);
            } 
          }
        }
      }
    }
  }
  
  public function getMetaData($file) {
    require_once "../../lib/extra/getid3/getid3.php";
    
    $getID3 = new getID3;
    $data = $getID3->analyze($file);

    return array(
              'mime' => $data['mime_type'],
              'resolution_x' => $data['video']['resolution_x'],
              'resolution_y' => $data['video']['resolution_y'],
              'filesize' => $data['filesize'],
              'duration' => $data['playtime_seconds'],
            );
  }
  
  public function glob_recursive($pattern, $flags = 0) {
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
      $files = array_merge($files, $this->glob_recursive($dir.'/'.basename($pattern), $flags));
    }
    return $files;
  }
  
  public function beforeFilter() {
    if ($this->Auth->user('user_id')) {
      $this->Auth->allow('index', 'get');
      $this->set('user', $this->Auth->user());
    }
  }

  private function flush_buffers() {
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
  }
 
  public function get($id = null) {
    $video = $this->Video->find('first', array('fields' => array('file', 'dir', 'ext', 'mime', 'size'), 'conditions' => array($this->Video->primaryKey => $id)))['Video'];
    
    
    $filename = $video['dir'].'/'.$video['file'];
    if (is_file($filename)) {
        header('Content-Type: '.$video['mime']);
        header('Content-Length: '.$video['size']);
        session_cache_limiter('nocache');
        header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
        header("Content-Disposition: attachment; filename=".$video['file']);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');
        
        $fd = fopen($filename, "rb");
        print(fread($fd, $video['size']));
        $this->flush_buffers();
        fclose($fd);
        //~ while(!feof($fd)) {
            //~ echo fread($fd, 1024 * 5000);
              //~ $this->flush_buffers();
            //~ }
        //~ fclose ($fd);
        exit();
    }
  }
}
