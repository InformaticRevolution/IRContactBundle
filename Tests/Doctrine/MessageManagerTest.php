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

use IR\Bundle\ContactBundle\Model\MessageInterface;
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
    
    
    /**
     * {@inheritdoc}
     */
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
            ->with($this->equalTo(self::MESSAGE_CLASS))
            ->will($this->returnValue($this->repository));        

        $this->objectManager->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(self::MESSAGE_CLASS))
            ->will($this->returnValue($class));        
        
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(self::MESSAGE_CLASS));        
        
        $this->messageManager = new MessageManager($this->objectManager, self::MESSAGE_CLASS);
    }    
    
    public function testSave()
    {
        $message = $this->getMessage();
        
        $this->objectManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($message));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->messageManager->save($message);
    }
    
    public function testDelete()
    {
        $message = $this->getMessage();
        
        $this->objectManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($message));
        
        $this->objectManager->expects($this->once())
            ->method('flush');

        $this->messageManager->delete($message);
    }      

    public function testFind()
    {
        $id = 11;
        
        $this->repository->expects($this->once())
            ->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue(array()));

        $this->messageManager->find($id);
    }

    public function testFindOneBy()
    {
        $criteria = array("foo" => "bar");
        
        $this->repository->expects($this->once())
            ->method('findOneBy')
            ->with($this->equalTo($criteria))
            ->will($this->returnValue(array()));

        $this->messageManager->findOneBy($criteria);
    }
    
    public function testFindBy()
    {
        $criteria = array("foo" => "bar");
        $orderBy = array("foo" => "asc");
        $limit = 3;
        $offset = 0;
        
        $this->repository->expects($this->once())
            ->method('findBy')
            ->with(
                $this->equalTo($criteria), 
                $this->equalTo($orderBy), 
                $this->equalTo($limit), 
                $this->equalTo($offset)
            )
            ->will($this->returnValue(array()));

        $this->messageManager->findBy($criteria, $orderBy, $limit, $offset);
    }    
    
    public function testGetClass()
    {
        $this->assertEquals(self::MESSAGE_CLASS, $this->messageManager->getClass());
    }
    
    /**
     * @return MessageInterface
     */
    protected function getMessage()
    {
        $class = self::MESSAGE_CLASS;

        return new $class();
    }     
}
