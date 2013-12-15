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
     * Show the contact form.
     */
    public function indexAction(Request $request)
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
            $dispatcher->dispatch(IRContactEvents::MESSAGE_SUBMITTED, new MessageEvent($message));            
            
            return new RedirectResponse($this->container->get('router')->generate('ir_contact_index'));  
        }
        
        return $this->renderIndex(array(
            'form' => $form->createView(),
        ));         
    }

    /**
     * Renders the index template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the index template.
     * 
     * array $data
     */
    public function renderIndex(array $data)
    {
        $template = sprintf('IRContactBundle:Contact:index.html.%s', $this->container->getParameter('ir_contact.template.engine'));
        
        return $this->container->get('templating')->renderResponse($template, $data);          
    }
}
