<?php

namespace Recipy\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Class SignUpType
 * @package Recipy\Form
 */
class SignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logins', Type\TextType::class, [
                'label' => 'username',
                'constraints' => [new NotBlank()]
            ])
            ->add('mdp', Type\RepeatedType::class, array(
                'type'           => Type\PasswordType::class,
                'options'        => array('attr' => array('class' => 'password-field')),
                'required'       => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
                'constraints' => [new UserPassword()],
                'invalid_message' => 'The password fields must match.',
            ));
    }

    public function getName()
    {
        return 'sign_in';
    }
}
