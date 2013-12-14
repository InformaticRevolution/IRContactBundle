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

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use IR\Bundle\ContactBundle\IRContactEvents;
use IR\Bundle\ContactBundle\Event\MessageEvent;
use IR\Bundle\ContactBundle\Model\MessageInterface;

/**
 * Controller managing the messages.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MessageController extends ContainerAware
{
    /**
     * List all the messages.
     */
    public function listAction()
    {
        $messages = $this->container->get('ir_contact.manager.message')->findMessagesBy(array(), array('createdAt' => 'DESC'));

        return $this->container->get('templating')->renderResponse('IRContactBundle:Message:list.html.'.$this->getEngine(), array(
            'messages' => $messages,
        ));
    }     
    
    /**
     * Show message details.
     */
    public function showAction($id)
    {
        $message = $this->findMessageById($id);

        return $this->container->get('templating')->renderResponse('IRContactBundle:Message:show.html.'.$this->getEngine(), array(
            'message' => $message,
        ));
    }       
    
    /**
     * Delete a message.
     */
    public function deleteAction($id)
    {
        $message = $this->findMessageById($id);
        $this->container->get('ir_contact.manager.message')->deleteMessage($message);
        
        /* @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');          
        $dispatcher->dispatch(IRContactEvents::MESSAGE_DELETE_COMPLETED, new MessageEvent($message));
        
        return new RedirectResponse($this->container->get('router')->generate('ir_contact_message_list'));   
    }       
    
    /**
     * Finds a message by id.
     *
     * @param mixed $id
     *
     * @return MessageInterface
     * 
     * @throws NotFoundHttpException When message does not exist
     */
    protected function findMessageById($id)
    {
        $message = $this->container->get('ir_contact.manager.message')->findMessageBy(array('id' => $id));

        if (null === $message) {
            throw new NotFoundHttpException(sprintf('The message with id %s does not exist', $id));
        }

        return $message;
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
