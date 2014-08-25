<?php

/*
 * This file is part of the IRContactBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Tests\Model;

use IR\Bundle\ContactBundle\Model\MessageInterface;

/**
 * Message Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{  
    /**
     * @dataProvider getSimpleTestData
     */
    public function testSimpleSettersGetters($property, $value, $default)
    {   
        $getter = 'get'.$property;
        $setter = 'set'.$property;
        
        $message = $this->getMessage();

        $this->assertEquals($default, $message->$getter());
        $this->assertSame($message, $message->$setter($value));
        $this->assertEquals($value, $message->$getter());
    }
    
    public function getSimpleTestData()
    {
        return array(
            array('email', 'test@example.com', null),
            array('subject', 'New message', null),
            array('body', 'Some message...', null),
            array('createdAt', new \DateTime(), null),
        );
    }     
    
    /**
     * @return MessageInterface
     */
    protected function getMessage()
    {
        return $this->getMockForAbstractClass('IR\Bundle\ContactBundle\Model\Message');
    }      
}
