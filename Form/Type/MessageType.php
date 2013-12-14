<?php

/*
 * This file is part of the IRContactBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Message Type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MessageType extends AbstractType
{
    /**
     * @var string
     */         
    protected $class;

    
    /**
     * Constructor.
     * 
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, array(                 
                'label' => 'form.message.email',
                'translation_domain' => 'ir_contact',
            ))   
            ->add('subject', null, array(                 
                'label' => 'form.message.subject',
                'translation_domain' => 'ir_contact',
            ))   
            ->add('body', null, array(                 
                'label' => 'form.message.body',
                'translation_domain' => 'ir_contact',
            ));
    }
   
    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'message',
        ));        
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_contact_message';
    }   
}