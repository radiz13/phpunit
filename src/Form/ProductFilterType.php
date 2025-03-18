<?php
namespace App\Form;

use AllowDynamicProperties;
use App\Entity\Product;
use App\Entity\ProductMarque;
use App\Entity\ProductTechno;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

#[AllowDynamicProperties]
class ProductFilterType extends AbstractType
{
    public function __construct(
        ProductRepository $productRepository,
    )
    {
        $this->productRepository = $productRepository;
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void
    {
        // Récupérer tous les types uniques de la base
        $types = $this->productRepository->createQueryBuilder('p')
            ->select('DISTINCT p.type')
            ->getQuery()
            ->getSingleColumnResult()
        ;

        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Nom du produit',
                'attr' => ['placeholder' => 'Rechercher...']
            ])
            ->add('type', ChoiceType::class, [
                'choices' => array_combine($types, $types),
                'required' => false,
                'placeholder' => 'Tous types',
                'label' => 'Type de dalle',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('priceMin', NumberType::class, [
                'required' => false,
                'label' => 'Prix min'
            ])
            ->add('priceMax', NumberType::class, [
                'required' => false,
                'label' => 'Prix max'
            ])
            ->add('taille', NumberType::class, [
                'required' => false,
                'label' => 'Diagonale (pouces)'
            ])
            ->add('techno', EntityType::class, [
                'class' => ProductTechno::class,
                'choice_label' => 'reso',
                'required' => false,
                'placeholder' => 'Toutes technologies',
                'label' => 'Technologie',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('marque', EntityType::class, [
                'class' => ProductMarque::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Toutes marques',
                'label' => 'Marque'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false, // Désactiver le CSRF
        ]);
    }
}
