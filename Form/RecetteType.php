<?php

namespace Recipy\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class RecipyType
 * @package Recipy\Form
 */
class RecipyType extends AbstractType
{
    /**
    //private $id;
    //private $autreId;
    private $titre;
    private $contenu;
    private $image;
    private $visible;
    private $partage;
    private $type;
    private $fid;
     * */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', Type\TextType::class)
            ->add('contenu', Type\TextareaType::class)
            ->add('image', Type\FileType::class)
            ->add('visible', Type\FileType::class)
            ->add('partage', Type\FileType::class)
            ->add('type', Type\FileType::class)
        ;
    }

    public function getName()
    {
        return 'recipy';
    }
}
