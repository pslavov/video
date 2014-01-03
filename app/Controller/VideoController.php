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
    
    debug($this->Video->find('all'));
    exit;
	}
  
  private function scanDir() {
    
    $Iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->video_dir));
    //~ $Regex = new RegexIterator($Iterator, '/^.+\.(avi|mkv|mp4|flv|mpg|mpeg|mov)$/i', RecursiveRegexIterator::GET_MATCH);
    
    $existing_videos = $this->Video->getAllFilenames();
    
    $pattern = '/^(avi|mkv|mp4|flv|mpg|mpeg|mov)$/i';
    $all_fl_info = array();
    foreach ($Iterator as $f) {
      if (preg_match($pattern, $f->getExtension())) {
        
        $create_new = True;
        if (array_key_exists($f->getPath(), $existing_videos)) 
          if (in_array($f->getFilename(), $existing_videos[$f->getPath()])) 
            $create_new = False;
          
        if ($create_new) {
            $size = $f->getSize();
            if ($size < 0) {
              $size = $this->RealFileSize($f->getPathname()); 
            }
            $data = array('file' => $f->getFilename(),
                          'dir' => $f->getPath(),
                          'ext' => $f->getExtension(),
                          'mtime' => date("Y-m-d H:i:s", $f->getMTime()),
                          'size' => $size,
                    );
            $this->Video->create();
            $this->Video->save($data);
        } 
      }
    }
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
      $this->Auth->allow('index');
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

}
