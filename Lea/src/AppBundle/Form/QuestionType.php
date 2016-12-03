<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class)
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Évaluation en entreprise' => 3,
                    'Missions en entreprise' => 5,
                    'Rapport d\'activité au centre de formation' => 1,
                    'Rapport d\'activité en entreprise' => 2,
                    'Visite en entreprise' => 4,
                ),
            ))
            ->add('typeQuestion', ChoiceType::class, array(
                'choices' => array(
                    'Liste à choix unique' => 2,
                    'Texte libre' => 1,
                ),
            ))
            ->add('cible', ChoiceType::class, array(
                'choices' => array(
                    'Étudiant' => 1,
                    'Maître d\'apprentissage' => 3,
                    'Tuteur pédagogique' => 2,
                ),
            ))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }
}