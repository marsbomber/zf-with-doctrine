<?php

class PostTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    private $_postPdo;

    public function setUp()
    {
        $this->_postPdo = Doctrine::getTable('Model_Post');
    }

    public function testCanCreatePost()
    {
        
        $numOfPostsBefore = $this->_postPdo->count();

        $p = new Model_Post();
        $p->title = 'Hoolala';
        $p->content = 'what can I say?';
        $p->save();
        $this->assertTrue(intval($p->id) > 0);
        
        $numOfPostsAfter = $this->_postPdo->count();
        
        $this->assertTrue(($numOfPostsAfter - $numOfPostsBefore) === 1);
    }
    
    public function testCanGetPostAuthorName()
    {
        $post = $this->_postPdo->findOneById(1);
        
        $authorName = $post->getAuthorName();
        
        $this->assertEquals('John Smith', $authorName);
    }

    public function tearDown()
    {

    }
}