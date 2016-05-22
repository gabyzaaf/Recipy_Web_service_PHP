<?php

namespace Recipy\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class UserType
 * @package Recipy\Form
 */
class SignInType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logins', Type\TextType::class)
            ->add('mdp', Type\RepeatedType::class, array(
                'type'            => Type\PasswordType::class,
                'options'         => array('attr' => array('class' => 'password-field')),
                'required'        => true,
                'first_options'   => array('label' => 'Password'),
                'second_options'  => array('label' => 'Repeat Password'),
            ));
    }

    public function getName()
    {
        return 'sign_in';
    }
}
