<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisplayQuestionnaireType extends AbstractType
{
    private $nbQuestion;

    public function __construct($nbQuestion = null) {
        $this->nbQuestion = $nbQuestion;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->nbQuestion = sizeof($options['questions']);

        $builder
            ->add('questions', CollectionType::class, array(
            'entry_type' => DisplayQuestionType::class,
            'entry_options' => array(
                'question' => $options['questions'],
                'reponses' => $options['reponses'],
                'nbQuestion' => $this->nbQuestion,
                'em' => $options['em'],
                'display' => 2,
            )))
            ->add('save', SubmitType::class, array('label' => 'Enregistrer brouillon'))
            ->add('validate', SubmitType::class, array('label' => 'Signer'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Questionnaire',
            'questionnaire' => null,
            'questions' => null,
            'reponses' => null,
            'em' => null
        ));
    }
}