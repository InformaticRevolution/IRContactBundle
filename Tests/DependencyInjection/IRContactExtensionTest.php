<?php

/*
 * This file is part of the IRContactBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Tests\DependencyInjection;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use IR\Bundle\ContactBundle\DependencyInjection\IRContactExtension;

/**
 * Contact Extension Test.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRContactExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** 
     * @var ContainerBuilder
     */
    protected $configuration;
    
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionUnlessDatabaseDriverSet()
    {
        $loader = new IRContactExtension();
        $config = $this->getEmptyConfig();
        unset($config['db_driver']);
        $loader->load(array($config), new ContainerBuilder());
    }  
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionUnlessDatabaseDriverIsValid()
    {
        $loader = new IRContactExtension();
        $config = $this->getEmptyConfig();
        $config['db_driver'] = 'foo';
        $loader->load(array($config), new ContainerBuilder());
    }     
    
    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testContactLoadThrowsExceptionUnlessMessageModelClassSet()
    {
        $loader = new IRContactExtension();
        $config = $this->getEmptyConfig();
        unset($config['message_class']);
        $loader->load(array($config), new ContainerBuilder());
    }         
    
    public function testDisableMessage()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRContactExtension();
        $config = $this->getEmptyConfig();
        $config['message'] = false;
        $loader->load(array($config), $this->configuration);
        $this->assertNotHasDefinition('ir_contact.form.name.message');
    } 

    public function testContactLoadModelClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('Acme\ContactBundle\Entity\Message', 'ir_contact.model.message.class');
    }       
    
    public function testContactLoadModelClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('Acme\ContactBundle\Entity\Message', 'ir_contact.model.message.class');
    }      
    
    public function testContactLoadManagerClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('orm', 'ir_contact.db_driver');
        $this->assertAlias('ir_contact.manager.message.default', 'ir_contact.manager.message');
    }       

    public function testContactLoadManagerClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('orm', 'ir_contact.db_driver');
        $this->assertAlias('acme_contact.manager.message', 'ir_contact.manager.message');
    }       
    
    public function testContactLoadFormClassWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_contact_message', 'ir_contact.form.type.message');
    }        
    
    public function testContactLoadFormClass()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_contact_message', 'ir_contact.form.type.message');
    }    
    
    public function testContactLoadFormNameWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('ir_contact_message_form', 'ir_contact.form.name.message');
    }       
    
    public function testContactLoadFormName()
    {
        $this->createFullConfiguration();

        $this->assertParameter('acme_contact_message_form', 'ir_contact.form.name.message');
    }      
    
    public function testContactLoadFormServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertHasDefinition('ir_contact.form.message');
    }     
    
    public function testContactLoadFormService()
    {
        $this->createFullConfiguration();

        $this->assertHasDefinition('ir_contact.form.message');
    }       

    public function testContactLoadNotificationWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertNotHasDefinition('ir_contact.notification.template');
    }    
    
    public function testContactLoadNotification()
    {
        $this->createFullConfiguration();

        $this->assertParameter('AcmeBundle:Notification:message.txt.twig', 'ir_contact.notification.template');
        $this->assertParameter(array('sender@example.com' => 'Foo Bar'), 'ir_contact.notification.from_email');
        $this->assertParameter(array('recipient@acme.com'), 'ir_contact.notification.to_email');
    }    
    
    public function testContactLoadServiceWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertNotHasDefinition('ir_contact.mailer');
    }     

    public function testContactLoadService()
    {
        $this->createFullConfiguration();

        $this->assertAlias('ir_contact.mailer.default', 'ir_contact.mailer');
    }    
    
    public function testContactLoadTemplateConfigWithDefaults()
    {
        $this->createEmptyConfiguration();

        $this->assertParameter('twig', 'ir_contact.template.engine');
    }      
    
    public function testContactLoadTemplateConfig()
    {
        $this->createFullConfiguration();

        $this->assertParameter('php', 'ir_contact.template.engine');
    }         
    
    protected function createEmptyConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRContactExtension();
        $config = $this->getEmptyConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }      
    
    protected function createFullConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new IRContactExtension();
        $config = $this->getFullConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }       
    
    /**
     * @return array
     */
    protected function getEmptyConfig()
    {
        $parser = new Parser();
        
        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/minimal_config.yml'));
    }    
    
    /**
     * @return array
     */    
    protected function getFullConfig()
    {
        $parser = new Parser();

        return $parser->parse(file_get_contents(__DIR__.'/Fixtures/full_config.yml'));
    }     

    /**
     * @param string $value
     * @param string $key
     */
    private function assertAlias($value, $key)
    {
        $this->assertEquals($value, (string) $this->configuration->getAlias($key), sprintf('%s alias is correct', $key));
    }      
    
    /**
     * @param mixed  $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->configuration->getParameter($key), sprintf('%s parameter is incorrect', $key));
    }      
    
    /**
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }      
    
    /**
     * @param string $id
     */
    private function assertNotHasDefinition($id)
    {
        $this->assertFalse(($this->configuration->hasDefinition($id) ?: $this->configuration->hasAlias($id)));
    }      
    
    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->configuration);
    }     
}
