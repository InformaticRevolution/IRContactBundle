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

/**
 * Abstract Message Manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class MessageManager implements MessageManagerInterface
{
    /**
     * {@inheritdoc}
     */  
    public function createMessage()
    {
        $class = $this->getClass();
        
        return new $class();
    }
}
