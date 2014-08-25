<?php

/*
 * This file is part of the IRContactBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Tests\Manager;

use IR\Bundle\ContactBundle\Manager\MessageManagerInterface;

/**
 * Message Manager Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MessageManagerTest extends \PHPUnit_Framework_TestCase
{
    const MESSAGE_CLASS = 'IR\Bundle\ContactBundle\Tests\TestMessage';
 
    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;    
    
    
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->messageManager = $this->getMockForAbstractClass('IR\Bundle\ContactBundle\Manager\MessageManager');
        
        $this->messageManager->expects($this->any())
            ->method('getClass')
            ->will($this->returnValue(self::MESSAGE_CLASS));        
    }
    
    public function testCreate()
    {        
        $message = $this->messageManager->create();
        
        $this->assertInstanceOf(self::MESSAGE_CLASS, $message);
    }
}