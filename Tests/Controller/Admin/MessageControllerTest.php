<?php

/*
 * This file is part of the IRContactBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Tests\Controller\Admin;

use IR\Bundle\ContactBundle\Tests\Functional\WebTestCase;

/**
 * Message Controller Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MessageControllerTest extends WebTestCase
{       
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->loadFixtures('message');
    } 
    
    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/admin/messages/');

        $this->assertResponseStatusCode(200);
        $this->assertCount(3, $crawler->filter('table tbody tr'));
    }
    
    public function testShowAction()
    {
        $this->client->request('GET', '/admin/messages/1');
        
        $this->assertResponseStatusCode(200);
    }        
    
    public function testDeleteAction()
    {
        $this->client->request('GET', '/admin/messages/1/delete');
        
        $this->assertResponseStatusCode(302);
        
        $crawler = $this->client->followRedirect();
        
        $this->assertResponseStatusCode(200);
        $this->assertCurrentUri('/admin/messages/');
        $this->assertCount(2, $crawler->filter('table tbody tr'));
    }     
    
    public function testNotFoundHttpWhenMessageNotExist()
    {
        $this->client->request('GET', '/admin/messages/foo');
        $this->assertResponseStatusCode(404);        

        $this->client->request('GET', '/admin/messages/foo/delete');
        $this->assertResponseStatusCode(404);        
    }       
}
