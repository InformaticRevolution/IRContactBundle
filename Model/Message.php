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
 * Abstract Message implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Message implements MessageInterface
{
    /**
     * @var mixed
     */
    protected $id;
    
    /**
     * @var string
     */
    protected $email;    

    /**
     * @var string
     */
    protected $subject;    
    
    /**
     * @var string
     */
    protected $body;    
    
    /**
     * @var \Datetime
     */
    protected $createdAt;
    
    
    /**
     * {@inheritdoc}
     */  
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */  
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * {@inheritdoc}
     */  
    public function setEmail($email)
    {
        $this->email = $email;
    }            
    
    /**
     * {@inheritdoc}
     */  
    public function getSubject()
    {
        return $this->subject;
    }            
    
    /**
     * {@inheritdoc}
     */  
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
            
    /**
     * {@inheritdoc}
     */  
    public function getBody()
    {
        return $this->body;
    }            
    
    /**
     * {@inheritdoc}
     */  
    public function setBody($body)
    {
        $this->body = $body;
    }            
    
    /**
     * {@inheritdoc}
     */   
    public function getCreatedAt()
    {
        return $this->createdAt;
    }    

    /**
     * {@inheritdoc}
     */   
    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;        
    }            
}
