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
    public function create();
    
    /**
     * Saves a message.
     *
     * @param MessageInterface $message
     */
    public function save(MessageInterface $message);    
         
    /**
     * Deletes a message.
     *
     * @param MessageInterface $message
     */
    public function delete(MessageInterface $message);    

    /**
     * Finds a message by its identifier.
     *
     * @param mixed $id
     *
     * @return MessageInterface|null
     */
    public function find($id);

    /**
     * Finds a single message by a set of criteria.
     *
     * @param array $criteria
     *
     * @return MessageInterface|null
     */
    public function findOneBy(array $criteria);    
    
    /**
     * Finds messages by a set of criteria.
     *
     * @param array        $criteria
     * @param array|null   $orderBy
     * @param integer|null $limit
     * @param integer|null $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null); 

    /**
     * Returns the fully qualified class name.
     *
     * @return string
     */
    public function getClass(); 
}

