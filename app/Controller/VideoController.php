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
class VideoController extends AppController {

  public $uses = array('Video');
	public $components = array('Paginator');
  private $video_dir = "/disk2/data";

/**
 * index method
 *
 * @return void
 */
	public function index() {
    //
    
    $this->scanDir();
    $this->set('vids', $this->Video->find('all'));
    
    //~ exit;
    //~ 
    //~ echo '<script type="text/javascript" src="/jwplayer/jwplayer.js"></script>';
    //~ 
    //~ $i=1;
    //~ foreach ($this->Video->find('all') as $vid) {
      //~ $fname = $vid['Video']['dir'] .'/'. $vid['Video']['file'];
      //~ echo $this->Html->link(
                            //~ $vid['Video']['file'],
                            //~ array(
                                //~ 'controller' => 'video',
                                //~ 'action' => 'get',
                                //~ $vid['Video']['video_id']
                            //~ )
                        //~ );
      //~ 
      //~ if ( !in_array($vid['Video']['ext'], array('avi', 'mkv')) ) {
        //~ echo '<div id="video'.$vid['Video']['video_id'].'">Loading the player...</div>
  //~ 
              //~ <script type="text/javascript">
                  //~ jwplayer("video'.$vid['Video']['video_id'].'").setup({
                      //~ file: "'.$fname.'",
                      //~ width: "800",
                      //~ height: "600",
                      //~ displaytitle: "'.$vid['Video']['file'].'",
                      //~ title: "'.$vid['Video']['file'].'",
                  //~ });
              //~ </script>';
      //~ } else {
        //~ echo '<embed 
                //~ type="application/x-vlc-plugin" 
                //~ pluginspage="http://www.videolan.org"
                //~ version="VideoLAN.VLCPlugin.2"
                //~ target="'.$fname.'" 
                //~ width="800" 
                //~ height="600" 
                //~ autostart="no" 
                //~ controls="yes"
                //~ loop="no" 
                //~ hidden="no" 
              //~ /><br/>';
      //~ }
      //~ $i++;
      //~ if ($i > 3) break;
    //~ }
    //~ 
    //~ exit;
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
        if (array_key_exists($f->getPath(), $existing_videos)) 
          if (in_array($f->getFilename(), $existing_videos[$f->getPath()])) 
            $create_new = False;
          
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
        } else {
          if (!file_exists($full_path)) {
            //delete db record
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

  private function RealFileSize($fpath) {
      $fp = fopen($fpath, 'r');
      $pos = 0;
      $size = 1073741824;
      fseek($fp, 0, SEEK_SET);
      while ($size > 1)
      {
          fseek($fp, $size, SEEK_CUR);
  
          if (fgetc($fp) === false)
          {
              fseek($fp, -$size, SEEK_CUR);
              $size = (int)($size / 2);
          }
          else
          {
              fseek($fp, -1, SEEK_CUR);
              $pos += $size;
          }
      }
  
      while (fgetc($fp) !== false)  $pos++;
      
      fclose($fp);
      
      return $pos;
  }

  private function flush_buffers() {
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
  }
 
  public function get($id = null) {
    
    debug($id);
    debug($this->request->params);
    exit;
    
    
    $video = $this->find('first', array('fields' => array('file', 'dir', 'ext', 'mime')))['Video'];
    
    
    $filename = $video['dir'].'/'.$video['file'];
    if (is_file($filename)) {
        header('Content-Type: '.$video['mime']);
        header("Content-Disposition: attachment; filename=".$filename);
        $fd = fopen($filename, "r");
        while(!feof($fd)) {
            echo fread($fd, 1024 * 5);
              $this->flush_buffers();
            }
        fclose ($fd);
        exit();
    }
  }
}
