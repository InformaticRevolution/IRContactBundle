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
     * 
     * @return self
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
     * 
     * @return self
     */
    public function setSubject($subject);
    
    /**
     * Returns the body.
     * 
     * @return string
     */
    public function getBody();
    
    /**
     * Sets the body.
     * 
     * @param string $body
     * 
     * @return self
     */
    public function setBody($body);
    
    /**
     * Returns the creation time.
     *
     * @return \DateTime
     */
    public function getCreatedAt();   
    
    /**
     * Sets the creation time.
     * 
     * @param \DateTime $createdAt
     * 
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt);     
}
