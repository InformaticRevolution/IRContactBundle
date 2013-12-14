<?php

/*
 * This file is part of the IRContactBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;

use IR\Bundle\ContactBundle\IRContactEvents;
use IR\Bundle\ContactBundle\Event\MessageEvent;

/**
 * Controller managing the contact form.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ContactController extends ContainerAware
{
    /**
     * Send a new message: show the contact form.
     */
    public function sendAction(Request $request)
    {
        /* @var $messageManager \IR\Bundle\ContactBundle\Manager\MessageManagerInterface */
        $messageManager = $this->container->get('ir_contact.manager.message');
        $message = $messageManager->createMessage();        
        
        $form = $this->container->get('ir_contact.form.message');
        $form->setData($message);
        $form->handleRequest($request);  
        
        if ($form->isValid()) {
            $messageManager->updateMessage($message);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');          
            $dispatcher->dispatch(IRContactEvents::CONTACT_COMPLETED, new MessageEvent($message));            
            
            return new RedirectResponse($this->container->get('router')->generate('ir_contact_send'));  
        }
        
        return $this->container->get('templating')->renderResponse('IRContactBundle:Contact:send.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));         
    }  

    /**
     * Returns the template engine.
     * 
     * @return string
     */    
   protected function getEngine()
    {
        return $this->container->getParameter('ir_contact.template.engine');
    } 
}