<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class VideoController extends AbstractActionController {
    public function indexAction() {
        echo "test";
    }
    
    public function addAction() {
      echo "test add";
    }
}

?>
