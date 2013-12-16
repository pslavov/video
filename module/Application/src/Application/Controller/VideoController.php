<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VideoController extends AbstractActionController {
    public function indexAction() {
      return new ViewModel(array('msg'=> "test"));
    }
    
    public function addAction() {
      return new ViewModel(array('msg'=> "test add"));
    }
}

?>
