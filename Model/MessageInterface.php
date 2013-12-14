<?php

/*
 * This file is part of the IRContactBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Model;

/**
 * Message Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface MessageInterface 
{
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();
    
    /**
     * Returns the email.
     * 
     * @return string
     */
    public function getEmail();
    
    /**
     * Sets the email.
     * 
     * @param string $email
     */
    public function setEmail($email);
    
    /**
     * Returns the subject.
     * 
     * @return string
     */
    public function getSubject();
    
    /**
     * Sets the subject.
     * 
     * @param string $subject
     */
    public function setSubject($subject);
    
    /**
     * Returns the message.
     * 
     * @return string
     */
    public function getMessage();
    
    /**
     * Sets the message.
     * 
     * @param string $message
     */
    public function setMessage($message);
    
    /**
     * Returns the creation time.
     *
     * @return \Datetime
     */
    public function getCreatedAt();   
    
    /**
     * Sets the creation time.
     * 
     * @param \Datetime $createdAt
     */
    public function setCreatedAt(\Datetime $createdAt);     
}
