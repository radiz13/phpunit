<?php

namespace App\Form;

use App\Entity\Devis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('number')
            ->add('designs', CollectionType::class, [
                'entry_type' => DevisDesignType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false],
//                'attr' => [
//                    'data-controller' => 'form-collection',
//                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
