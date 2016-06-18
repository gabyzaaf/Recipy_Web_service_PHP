<?php

namespace Recipy\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Class UserType
 * @package Recipy\Form
 */
class SignInType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logins', Type\TextType::class, [
                'label' => 'username',
                'constraints' => [new NotBlank()]
            ])
            ->add('mdp', Type\PasswordType::class, array(
                'required' => true,
                'label'    => 'Password',
                'constraints' => [new NotBlank()]
            ))
            ->add('remember', Type\CheckboxType::class, array('label' => 'Remeber ME'));
    }

    public function getName()
    {
        return 'sign_in';
    }
}
