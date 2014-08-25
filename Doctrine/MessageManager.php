<?php

/*
 * This file is part of the IRContactBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

use IR\Bundle\ContactBundle\Model\MessageInterface;
use IR\Bundle\ContactBundle\Manager\MessageManager as AbstractMessageManager;

/**
 * Doctrine Message Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MessageManager extends AbstractMessageManager
{
    /**
     * @var ObjectManager
     */          
    protected $objectManager;
    
    /**
     * @var ObjectRepository
     */           
    protected $repository;    

    /**
     * @var string
     */           
    protected $class;  
    
    
   /**
    * Constructor.
    *
    * @param ObjectManager $om
    * @param string        $class
    */        
    public function __construct(ObjectManager $om, $class)
    {           
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }      
    
    /**
     * {@inheritDoc}
     */  
    public function save(MessageInterface $message)
    {  
        $this->objectManager->persist($message);
        $this->objectManager->flush();
    }

    /**
     * {@inheritDoc}
     */     
    public function delete(MessageInterface $message)
    {
        $this->objectManager->remove($message);
        $this->objectManager->flush();          
    }
    
    /**
     * {@inheritDoc}
     */ 
    public function find($id)     
    {
        return $this->repository->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }    
    
    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limite = null, $offset = null)
    {
        return $this->repository->findBy($criteria, $orderBy, $limite, $offset);
    }

    /**
     * {@inheritDoc}
     */    
    public function getClass()
    {
        return $this->class;
    }
}
