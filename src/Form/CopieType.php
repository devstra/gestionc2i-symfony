<?php

namespace App\Form;

use App\Entity\Copie;
use App\Entity\Epreuve;
use App\Entity\Etudiant;
use App\Entity\Salle;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CopieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('correcteur', TextType::class, [
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('salle', EntityType::class, [
                'class' => Salle::class,
                'multiple' => false,
                'choice_label' => function ($salle) {
                    return $salle->getBatiment() . " " . $salle->getLieu() . " " . $salle->getEtage();
                },
            ])
            ->add('epreuve', EntityType::class, [
                'class' => Epreuve::class,
                'multiple' => false,
                'choice_label' => function ($epreuve) {
                    return $epreuve->getNomUFR() . " " . $epreuve->getAnnee();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.annee', 'DESC');
                },
            ])
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'multiple' => false,
                'choice_label' => function ($etudiant) {
                    return $etudiant->getNom() . " " . $etudiant->getPrenom();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.nom', 'ASC');
                },
            ])
            ->add('vague', TextType::class, [
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('noteD1', NumberType::class, [
                'scale' => 2,
                'label' => 'Note au domaine 1',
            ])
            ->add('noteD2', NumberType::class, [
                'scale' => 2,
                'label' => 'Note au domaine 2',
            ])
            ->add('noteTableur', NumberType::class, [
                'scale' => 2,
                'label' => 'Note de tableur',
            ])
            ->add('noteTraitementTexte', NumberType::class, [
                'scale' => 2,
                'label' => 'Note de traitement de texte',
            ])
            ->add('notePresentationAO', NumberType::class, [
                'scale' => 2,
                'label' => 'Note de présentation assistée par ordinateur',
            ])
            ->add('noteD4', NumberType::class, [
                'scale' => 2,
                'label' => 'Note au domaine 4',

            ])
            ->add('noteD5', NumberType::class, [
                'scale' => 2,
                'label' => 'Note au domaine 5',
            ]);

        $builder->get('correcteur')->addModelTransformer(new CallbackTransformer(
            function ($correcteur) {
                return strtoupper($correcteur);
            },
            function ($correcteur2) {
                return $correcteur2;
            }
        ));

        $builder->get('vague')->addModelTransformer(new CallbackTransformer(
            function ($vague) {
                return strtoupper($vague);
            },
            function ($uppervague) {
                return $uppervague;
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Copie::class,
        ]);
    }
}
