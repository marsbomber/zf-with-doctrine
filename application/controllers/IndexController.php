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

    public function emailAction()
    {
        $sc = $this->getInvokeArg('bootstrap')
            ->getResource('container');
        $sc->setParameter('mailer.username', 'overwritevalue');
        $sc->setParameter('mailer.password', 'overwritevalue');

        if(isset($sc->mailer)) {
            $sc->mailer->addTo('jimli@elinkmedia.net.au', 'Jim Li Elink')
                ->setFrom('jimjinli@gmail.com', 'Jim Li Personal')
                ->setSubject('Test Symfony DI')
                ->setBodyText('GOOD')
                ->send();

            echo 'Email sent utilising Symfony DI Container';
        }

    }
    
}



