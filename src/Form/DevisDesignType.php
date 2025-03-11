<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\DevisDesign;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisDesignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('design', null, [
                'label' => 'Désignation',
            ])
            ->add('quantity', null, [
                'label' => 'Quantité'
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'autocomplete' => true,
                'query_builder' => function (ProductRepository $r) {
                    return $r->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                },

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DevisDesign::class,
        ]);
    }
}
