<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('file', FileType::class, array(
                'required' => false,
                'label' => "Fichier"))
            ->add('typeDocument')
            ->add('visibleMAP', CheckboxType::class, array(
                'required' => false,
                'label' => "MAP"))
            ->add('visibleTuteur', CheckboxType::class, array(
                'required' => false,
                'label' => "Tuteur"))
            ->add('visibleResponsable', CheckboxType::class, array(
                'required' => false,
                'label' => "Responsable"))

            ->add('save', SubmitType::class, array('label' => 'Enregistrer document'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Document'
        ));
    }

    public function getName()
    {
        return 'documents';
    }
}