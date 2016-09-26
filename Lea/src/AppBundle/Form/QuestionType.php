<?php

namespace AppBundle\Form;


class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class)
            ->add('type', CheckboxType::class)
            ->add('cible', CheckboxType::class)
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