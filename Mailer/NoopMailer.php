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
 * This mailer does nothing.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class NoopMailer implements MailerInterface
{
    /**
     * {@inheritdoc}
     */
    public function sendNewMessageNotificationEmailMessage(MessageInterface $message) 
    {
        // Do nothing.
    }    
}
