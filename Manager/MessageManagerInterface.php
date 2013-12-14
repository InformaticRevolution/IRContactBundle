<?php

/*
 * This file is part of the IRContactBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Manager;

use IR\Bundle\ContactBundle\Model\MessageInterface;

/**
 * Message Manager Interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface MessageManagerInterface
{   
    /**
     * Creates an empty message instance.
     *
     * @return MessageInterface
     */    
    public function createMessage();
    
    /**
     * Updates a message.
     *
     * @param MessageInterface $message
     */
    public function updateMessage(MessageInterface $message);    
         
    /**
     * Deletes a message.
     *
     * @param MessageInterface $message
     */
    public function deleteMessage(MessageInterface $message);    

    /**
     * Finds a message by given criteria.
     *
     * @param array $criteria
     *
     * @return MessageInterface|null
     */
    public function findMessageBy(array $criteria);    
    
    /**
     * Finds messages by given criteria.
     * 
     * @param array      $criteria
     * @param array|null $orderBy
     * 
     * @return array
     */
    public function findMessagesBy(array $criteria, array $orderBy = null);

    /**
     * Returns the message's fully qualified class name.
     *
     * @return string
     */
    public function getClass(); 
}

