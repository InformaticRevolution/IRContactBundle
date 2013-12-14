<?php

/*
 * This file is part of the IRContactBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Contact Extension.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRContactExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load(sprintf('driver/%s/message.xml', $config['db_driver']));

        foreach (array('listeners') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }          
        
        $container->setParameter('ir_contact.db_driver', $config['db_driver']);
        $container->setParameter('ir_contact.model.message.class', $config['message_class']);
        $container->setParameter('ir_contact.template.engine', $config['template']['engine']);
        $container->setParameter('ir_contact.backend_type_' . $config['db_driver'], true);
        
        $container->setAlias('ir_contact.manager.message', $config['message_manager']);
        
        if (!empty($config['message'])) {
            $this->loadMessage($config['message'], $container, $loader);
        } 
        
        if (!empty($config['notification'])) {
            $this->loadMailer($container, $loader, $config['service']['mailer']);
            $this->loadNotification($config['notification'], $container, $loader, $config['service']['mailer']);
        }         
    }
    
    private function loadMessage(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {        
        $loader->load('message.xml');
        
        $container->setParameter('ir_contact.form.name.message', $config['form']['name']);
        $container->setParameter('ir_contact.form.type.message', $config['form']['type']);
        $container->setParameter('ir_contact.form.validation_groups.message', $config['form']['validation_groups']);
    }    
    
    private function loadNotification(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {   
        $loader->load('notification.xml');
        $fromEmail = $config['from_email'];

        $container->setParameter('ir_contact.notification.template', $config['template']);
        $container->setParameter('ir_contact.notification.from_email', array($fromEmail['address'] => $fromEmail['sender_name']));
        $container->setParameter('ir_contact.notification.to_email', $config['to_email']);
    }    
    
    private function loadMailer(ContainerBuilder $container, XmlFileLoader $loader, $mailer)
    {
        $loader->load('mailer.xml');
        $container->setAlias('ir_contact.mailer', $mailer);
    }
}
