<?php

namespace Jgalenski\DemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
        ;
    }

    public function getName()
    {
        return 'jgalenski_demobundle_articletype';
    }
}
