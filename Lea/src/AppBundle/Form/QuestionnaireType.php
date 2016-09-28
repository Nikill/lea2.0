<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class)
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Évaluation en entreprise' => 2,
                    'Missions en entreprise' => 4,
                    'Rapport d\'activité au centre de formation' => 0,
                    'Rapport d\'activité en entreprise' => 1,
                    'Visite en entreprise' => 3,
                ),
            ))
            ->add('dateOuverture', DateType::class, array(
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
            ))
            ->add('dateFermeture', DateType::class, array(
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
            ))
            ->add('save', SubmitType::class, array('label' => 'Créer un questionnaire'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Questionnaire'
        ));
    }
}