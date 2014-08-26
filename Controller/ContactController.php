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
     * Submit form and send notification.
     */
    public function submitAction(Request $request)
    {
        /* @var $messageManager \IR\Bundle\ContactBundle\Manager\MessageManagerInterface */
        $messageManager = $this->container->get('ir_contact.manager.message');
        $message = $messageManager->create();        
        
        $form = $this->container->get('ir_contact.form.message');
        $form->setData($message);
        $form->handleRequest($request);  

        if ($form->isValid()) {
            $messageManager->save($message);
            
            /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->container->get('event_dispatcher');          
            $dispatcher->dispatch(IRContactEvents::MESSAGE_SUBMITTED, new MessageEvent($message));            
            
            return new RedirectResponse($this->container->get('router')->generate('ir_contact_confirmed'));  
        }

        return $this->container->get('templating')->renderResponse('IRContactBundle:Contact:submit.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));        
    }
    
    /**
     * Confirm the user his message has been submitted.
     */
    public function confirmedAction()
    {
        return $this->container->get('templating')->renderResponse('IRContactBundle:Contact:confirmed.html.'.$this->getEngine(), array());
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
