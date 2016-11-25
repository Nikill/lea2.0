<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $permissions = array(
            'Etudiant'                  => 'ROLE_ETUDIANT',
            'Tuteur pédagogique'        => 'ROLE_TUTEUR',
            'Responsable de formation'  => 'ROLE_RESPONSABLE',
            "Maitre d'apprentissage"    => 'ROLE_MAP',
            'Administrateur'            => 'ROLE_SUPER_ADMIN'
        );
        $builder
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('email', EmailType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('adresse', TextType::class, array("required" => false))
            ->add('ville', TextType::class, array("required" => false))
            ->add('codePostal', TextType::class, array("required" => false))
            ->add('telephoneFix', TextType::class, array("required" => false))
            ->add('telephonePortable', TextType::class, array("required" => false))
            ->add('fax', TextType::class, array("required" => false))
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-MM-yyyy'
                ]
            ])
            ->add('estHandicape', CheckboxType::class, array("required" => false, 'label' => 'En situation de handicap'))
            ->add(
                'roles',
                ChoiceType::class,
                array(
                    'label'   => 'Rôle à attribuer',
                    'choices' => $permissions,
                    'multiple' => true
                )
            )
            ->add('save', SubmitType::class, array('label' => 'Créer un utilisateur'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}