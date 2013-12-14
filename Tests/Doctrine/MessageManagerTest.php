<?php

/*
 * This file is part of the IRContactBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Tests\Doctrine;

use IR\Bundle\ContactBundle\Doctrine\MessageManager;

/**
 * Message Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MessageManagerTest extends \PHPUnit_Framework_TestCase
{
    const MESSAGE_CLASS = 'IR\Bundle\ContactBundle\Tests\TestMessage';
    
    /**
     * @var MessageManager
     */
    protected $messageManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManager;
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;
    
    
    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }  
                
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
                
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::MESSAGE_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::MESSAGE_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::MESSAGE_CLASS));        
        
        $this->messageManager = new MessageManager($this->objectManager, static::MESSAGE_CLASS);
    }    
    
    public function testUpdateMessage()
    {
        $message = $this->getMessage();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($message));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->messageManager->updateMessage($message);
    }
    
    public function testDeleteMessage()
    {
        $message = $this->getMessage();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($message));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->messageManager->deleteMessage($message);
    }      
    
    public function testFindMessageBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->messageManager->findMessageBy($criteria);
    }
    
    public function testFindCategoriesBy()
    {
        $criteria = array("foo" => "bar");
        $orderBy = array("created" => 'DESC');
        
        $this->repository->expects($this->once())
            ->method('findBy')
            ->with($this->equalTo($criteria), $this->equalTo($orderBy))
            ->will($this->returnValue(array()));

        $this->messageManager->findMessagesBy($criteria, $orderBy);
    }    
    
    public function testGetClass()
    {
        $this->assertEquals(static::MESSAGE_CLASS, $this->messageManager->getClass());
    }
    
    protected function getMessage()
    {
        $class = static::MESSAGE_CLASS;

        return new $class();
    }     
}
