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
        $builder->add('username', Type\TextType::class)
            ->add('password', Type\PasswordType::class);
    }

    public function getName()
    {
        return 'sign_in';
    }
}
