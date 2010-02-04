<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $postDao = Doctrine::getTable('Model_Post');
//
//        $postObj = new Model_Post();
//        $postObj->fromArray(array('title'=>'oooooooo'));
//
//        $user = Doctrine::getTable('Model_User')->findoneById(1);
//        $postObj->author = $user;
//
//        $postObj->save();
//        exit;

        
        $posts = $postDao->findAll();
        $this->view->posts = $posts;

        foreach($posts as $post) {
            echo "Post";
            Zend_Debug::dump($post->toArray());

            $author = $post->author;
            echo "Poster";
            Zend_Debug::dump($author->toArray());

            $comments = $post->comments;
            foreach($comments as $comment) {
                echo "Comment";
                Zend_Debug::dump($comment->toArray());

                $commenter = $comment->author;
                echo "Commenter";
                Zend_Debug::dump($commenter->toArray());
            }
            echo "<hr />";
        }
    }
    
}



