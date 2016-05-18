<?php

namespace Recipy\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class UserType
 * @package Recipy\Form
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', Type\TextType::class)
            ->add('lastname', Type\TextType::class)
            ->add('email', Type\EmailType::class)
            ->add('birthday', Type\DateType::class);
        //->add('password', Type\TextType::class);
    }

    public function getName()
    {
        return 'user';
    }
}
