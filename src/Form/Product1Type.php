<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\ProductMarque;
use App\Entity\ProductTechno;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Product1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('price')
            ->add('taille')
            ->add('techno', EntityType::class, [
                'class' => ProductTechno::class,
                'choice_label' => 'id',
            ])
            ->add('marque', EntityType::class, [
                'class' => ProductMarque::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
