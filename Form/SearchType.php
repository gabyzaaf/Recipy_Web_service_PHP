<?php

namespace Recipy\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class SearchType
 * @package Recipy\Form
 */
class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', Type\TextType::class, [
                    'label'       => 'Title',
                    'required'    => true,
                ]
            )
        ;
    }

    /**
     * @return string
     */
    public function getParent() {
        return 'Symfony\Component\Form\Extension\Core\Type\FormType';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'search';
    }
}
