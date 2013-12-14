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

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use IR\Bundle\ContactBundle\Model\MessageInterface;

/**
 * Default Mailer implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Mailer implements MailerInterface
{
    /**
     * @var \Swift_Mailer
     */            
    protected $mailer;
    
    /**
     * @var EngineInterface
     */            
    protected $templating;
    
    /**
     * @var array
     */            
    protected $parameters;    
    
    
    /**
     * Constructor
     * 
     * @param \Swift_Mailer    $mailer
     * @param EngineInterface  $templating
     * @param array            $parameters
     */      
    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, array $parameters)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->parameters = $parameters;
    }    
    
    /**
     * {@inheritdoc}
     */      
    public function sendNewMessageNotificationEmailMessage(MessageInterface $message)
    {   
        $template = $this->parameters['template'];
        $rendered = $this->templating->render($template, array(
            'message' => $message,
        ));        
        
        $this->sendMessage($rendered, $this->parameters['from_email'], $this->parameters['to_email']);
    }    
    
    /**
     * Sends a message.
     * 
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body);

        $this->mailer->send($message);
    }    
}
