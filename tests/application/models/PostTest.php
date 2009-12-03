<?php

class PostTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {

    }

    public function testCanCreatePost()
    {
        $postDao = Doctrine::getTable('Model_Post');
        $numOfPostsBefore = $postDao->count();
        
        $p = new Model_Post();
        $p->title = 'Hoolala';
        $p->content = 'what can I say?';
        $p->save();
        $this->assertTrue(intval($p->id) > 0);
        
        $numOfPostsAfter = $postDao->count();
        
        $this->assertTrue(($numOfPostsAfter - $numOfPostsBefore) === 1);
    }

    public function tearDown()
    {

    }
}