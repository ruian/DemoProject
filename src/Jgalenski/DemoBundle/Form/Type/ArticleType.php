<?php

namespace Jgalenski\DemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'attr' => array(
                    'class' => 'span5'
                )
            ))
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'span5'
                )
            ))
            ->add('picture', 'hidden')
            ->add('picture_tmp', 'uploadify_ressource')
        ;
    }

    public function getName()
    {
        return 'jgalenski_demobundle_articletype';
    }
}
