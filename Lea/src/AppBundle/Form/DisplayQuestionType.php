<?php

namespace AppBundle\Form;

use AppBundle\Repository\ChoixRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisplayQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class)
            ->add('choix', EntityType::class, array(
                'class' => 'AppBundle\Entity\Choix',
                'choice_label' => 'description',
                'data' => 'id',
                'multiple' => false,
                'query_builder' => function(ChoixRepository $er) use ($options) {
                    return $er->getChoixQuestion($options['question']);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question',
            'question' => null
        ));
    }
}