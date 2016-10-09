<?php

namespace AppBundle\Form;

use AppBundle\Repository\ChoixRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisplayQuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['questionnaire']->getQuestions() as $question) {
            $builder->add('description', TextareaType::class);
            $builder->add('choix', EntityType::class, array(
                'class' => 'AppBundle\Entity\Choix',
                'choice_label' => 'description',
                'data' => 'id',
                'multiple' => false,
                'query_builder' => function(ChoixRepository $er) use ($question) {
                    return $er->getChoixQuestion($question);
                }
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Questionnaire',
            'questionnaire' => null
        ));
    }
}