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
        $builder->add('prenom', Type\TextType::class)
            ->add('nom', Type\TextType::class)
            ->add('email', Type\EmailType::class)
            ->add('naissance', Type\DateType::class,
                array(
                    'years'  => range(date('Y') - 16, date('Y') - 100),
                    'format' => 'dd / MM / yyyy',
                )   );
        //->add('password', Type\TextType::class);
    }

    public function getName()
    {
        return 'user';
    }
}
