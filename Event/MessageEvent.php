<?php

/*
 * This file is part of the IRContactBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use IR\Bundle\ContactBundle\Model\MessageInterface;

/**
 * Message Event.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MessageEvent extends Event
{
    /**
     * @var MessageInterface
     */        
    protected $message;
    
    
   /**
    * Constructor.
    *
    * @param MessageInterface $message
    */         
    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * Returns the message.
     * 
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }
}