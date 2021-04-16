<?php

namespace App\Form;

use App\Entity\Epreuve;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpreuveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('barre', NumberType::class, [
                'label' => 'Barre',
                'scale' => 2,
            ])
            ->add('nomUFR', TextType::class, [
                'label' => 'Nom de l\'UFR',
            ])
            ->add('annee', IntegerType::class, [
                'label' => 'Année',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Epreuve::class,
        ]);
    }
}
