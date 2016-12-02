<?php

namespace AppBundle\Form;

use AppBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisplayQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['display'] == 1) {
            $this->createBuilder($builder, $options['question'], $options['em']);
        } else {
            foreach ($options['question'] as $question) {
                $this->createBuilder($builder, $question, $options['em']);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question',
            'question' => null,
            'em' => null,
            'display' => null
        ));
    }

    private function createBuilder(FormBuilderInterface $builder, Question $question, $em) {
        if (!is_null($question)) {
            switch($question->getTypeQuestion()) {
                case 1:
                    $builder->add('description', TextareaType::class, array(

                    ));
                    break;
                case 2:
                    $builder->add('choix', ChoiceType::class, array(
                        'choices' => $this->fillChoix($question, $em),
                        'multiple' => false,
                        'expanded' => true
                    ));
                    break;
            }
        }
    }

    private function fillChoix(Question $question, $em) {
        $er = $em->getRepository('AppBundle:Choix');

        $results = $er->createQueryBuilder('c');
        $results -> leftJoin('c.questions', 'q');
        $results -> where($results->expr()->eq('q.id', ':question'));
        $results -> setParameter('question', $question->getId());
        $results -> orderby('c.rang', 'ASC');
        $results = $results->getQuery();
        $results = $results->getResult();

        $choices = array();
        foreach($results as $choix){
            $choices[$choix->getDescription()] = $choix;
        }

        return $choices;
    }
}