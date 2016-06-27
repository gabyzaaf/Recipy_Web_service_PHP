<?php

namespace Recipy\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RecipyType
 * @package Recipy\Form
 */
class RecipyType extends AbstractType
{
    protected $session;

    /**
     * RecipyType constructor.
     *
     * @param Session $session
     */
    public function __construct($session)
    {
        $this->session = $session;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->session->get('user');
        $data = $options['data'];

        $builder
            ->add('title', Type\TextType::class, [
                    'label'       => 'Title',
                    'required'    => true,
                    'constraints' => [new NotBlank()],
                    'disabled' => $user->getId() == ($data->getCurrentOwn() ?? false) ?? false,
                ]
            )
            ->add('contenu', Type\TextareaType::class)
            ->add('file', Type\FileType::class, [
                'attr' => ['accept' => 'image/*'] // todo : add js to manage this, doesn't work to chrome ( image/gif )
            ])
            ->add('image', Type\HiddenType::class, ['required' => !!$user->getId()])
            ->add('visible', Type\CheckboxType::class, ['required' => false, 'value' => true])
//            ->add('partage', Type\CheckboxType::class)//->add('type', Type\FileType::class)
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
        return 'recipy';
    }
}
