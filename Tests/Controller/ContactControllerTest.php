<?php

/*
 * This file is part of the IRContactBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Tests\Controller;

use IR\Bundle\ContactBundle\Tests\Functional\WebTestCase;

/**
 * Contact Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ContactControllerTest extends WebTestCase
{   
    const FORM_INTENTION = 'message';
    
    
    public function testNewActionGetMethod()
    {
        $crawler = $this->client->request('GET', '/contact-us/');

        $this->assertResponseStatusCode(200);
        $this->assertCount(1, $crawler->filter('form'));
    }
    
    public function testNewActionPostMethod()
    {        
        $this->client->request('POST', '/contact-us/', array(
            'ir_contact_message_form' => array (
                'email' => 'foo@gmail.com',
                'subject' => 'New message',
                'message' => 'Some message...',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $this->assertResponseStatusCode(302);
        
        $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/contact-us/');
    }  
    
    public function testNewMessageNotificationSent()
    {           
        $this->client->enableProfiler();
        $this->client->request('POST', '/contact-us/', array(
            'ir_contact_message_form' => array (
                'email' => 'foo@gmail.com',
                'subject' => 'New message',
                'message' => 'Some message...',
                '_token' => $this->generateCsrfToken(static::FORM_INTENTION),
            ) 
        ));  
        
        $collector = $this->client->getProfile()->getCollector('swiftmailer');
        $this->assertEquals(1, $collector->getMessageCount());
        
        $messages = $collector->getMessages();
        $message = $messages[0];
        
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('sender@example.com', key($message->getFrom()));
        $this->assertEquals('recipient@example.com', key($message->getTo()));
    }
}
