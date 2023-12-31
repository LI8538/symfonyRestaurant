<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('title')
            ->add('content')
            ->add('publishedAt')
            ->add('image', FileType::class, [
                'mapped' => false,
                'label' => 'Titre de l\'article',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name', // En supposant que 'name' est la propriété dans l'entité Category
            ])
            //ne pas mettre "user" en raison la personne connecte qui va rédiger la publication systématiquement
            // ->add('user', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'name', // En supposant que 'name' est la propriété dans l'entité User
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
