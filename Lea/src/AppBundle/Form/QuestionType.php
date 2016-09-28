<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class)
            ->add('type', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices' => array(
                    'Évaluation en entreprise' => 2,
                    'Missions en entreprise' => 4,
                    'Rapport d\'activité au centre de formation' => 0,
                    'Rapport d\'activité en entreprise' => 1,
                    'Visite en entreprise' => 3,
                ),
            ))
            ->add('cible', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices' => array(
                    'Étudiant' => 0,
                    'Maître d\'apprentissage' => 2,
                    'Tuteur pédagogique' => 1,
                ),
            ))
            ->add('save', SubmitType::class, array('label' => 'Créer une question'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }
}