<?php

namespace IR\Bundle\ContactBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use IR\Bundle\ContactBundle\IRContactEvents;
use IR\Bundle\ContactBundle\Event\MessageEvent;
use IR\Bundle\ContactBundle\Mailer\MailerInterface;

/**
 * Notification Listener.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class NotificationListener implements EventSubscriberInterface
{
    /**
     * @var MailerInterface
     */          
    protected $mailer;

    
    /**
     * Constructor.
     * 
     * @param MailerInterface $mailer
     */           
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */       
    public static function getSubscribedEvents()
    {
        return array(
            IRContactEvents::MESSAGE_SUBMITTED => 'sendNotification',
        );
    }

    /**
     * Sends a new message notification.
     * 
     * @param MessageEvent $event
     */
    public function sendNotification(MessageEvent $event)
    {   
        $message = $event->getMessage();
        $this->mailer->sendNewMessageNotificationEmailMessage($message);
    }
}