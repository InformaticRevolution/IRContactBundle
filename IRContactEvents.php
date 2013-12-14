<?php

/*
 * This file is part of the IRContactBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle;

/**
 * Contains all events thrown in the IRContactBundle.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
final class IRContactEvents
{
    /**
     * The CONTACT_COMPLETED event occurs after saving the message in the contact process.
     *
     * The event listener method receives a IR\Bundle\ContactBundle\Event\MessageEvent instance.
     */
    const CONTACT_COMPLETED = 'ir_contact.contact.completed';     
    
    /**
     * The MESSAGE_DELETE_COMPLETED event occurs after deleting the message.
     *
     * The event listener method receives a IR\Bundle\ContactBundle\Event\MessageEvent instance.
     */
    const MESSAGE_DELETE_COMPLETED = 'ir_contact.message.delete.completed'; 
}