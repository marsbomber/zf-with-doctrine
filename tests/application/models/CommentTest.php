<?php

class CommentTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    private $_commentDao;
    
    public function setUp()
    {
        $this->_commentDao = Doctrine::getTable('Model_Comment');
    }
    
    public function testCanGetCommentAuthorName()
    {
        $comment = $this->_commentDao->findOneById(1);
        
        $authorName = $comment->getAuthorName();
        
        $this->assertEquals('Charlie Michael', $authorName);
    }

    public function tearDown()
    {

    }
}