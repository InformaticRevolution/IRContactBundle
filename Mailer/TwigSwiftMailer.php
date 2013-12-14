<?php

namespace IR\Bundle\ContactBundle\Mailer;

use IR\Bundle\ContactBundle\Model\MessageInterface;

/**
 * Twig Swift Mailer implementation.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class TwigSwiftMailer implements MailerInterface
{
    /**
     * @var \Swift_Mailer
     */            
    protected $mailer;
    
    /**
     * @var \Twig_Environment
     */            
    protected $twig;
    
    /**
     * @var array
     */            
    protected $parameters;    


    /**
     * Constructor
     * 
     * @param \Swift_Mailer     $mailer
     * @param \Twig_Environment $twig
     * @param array             $parameters
     */      
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, array $parameters)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */      
    public function sendNewMessageNotificationEmailMessage(MessageInterface $message)
    {   
        $template = $this->parameters['template'];
        $context = array('message' => $message);
        
        $this->sendMessage($template, $context, $this->parameters['from_email'], $this->parameters['to_email']);
    }      

    /**
     * Sends a message.
     *
     * @param string $templateName
     * @param array  $context
     * @param array  $fromEmail
     * @param array  $toEmail
     */    
    protected function sendMessage($templateName, array $context, array $fromEmail, array $toEmail)
    {   
        $context = $this->twig->mergeGlobals($context);
        $template = $this->twig->loadTemplate($templateName);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
        ;

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        $this->mailer->send($message);
    }
}