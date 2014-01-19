<?php

/*
 * This file is part of the IRContactBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Mailer;

use IR\Bundle\ContactBundle\Model\MessageInterface;

/**
 * Mailer Interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface MailerInterface
{
    /**
     * Send an email to notify that a new message has been sent.
     *
     * @param MessageInterface $message
     */
    function sendNewMessageNotificationEmailMessage(MessageInterface $message);   
}