<?php
//require_once 'BaseMessage.php';
//require_once 'Message.php';

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $postDao = Doctrine::getTable('Model_Post');
        
        $posts = $postDao->findAll();
        $this->view->posts = $posts;
    }
    
}



