<?php

namespace Recipy\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RecipyType
 * @package Recipy\Form
 */
class RecipyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump($builder);
        $builder
            ->add('titre', Type\TextType::class, [
                    'label'       => 'Title',
                    'required'    => true,
                    'constraints' => [new NotBlank()]
                ]
            )
            ->add('contenu', Type\TextareaType::class)
            ->add('file', Type\FileType::class, [
                'attr' => ['accept' => 'image/*'] // todo : add js to manage this, doesn't work to chrome ( image/gif )
            ])
            ->add('image', Type\HiddenType::class)
            ->add('visible', Type\CheckboxType::class, ['required' => false, 'value' => true])
//            ->add('partage', Type\CheckboxType::class)//->add('type', Type\FileType::class)
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'recipy';
    }
}
