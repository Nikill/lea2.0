<?php

namespace AppBundle\Form;

use AppBundle\Entity\Question;
use AppBundle\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisplayQuestionType extends AbstractType
{
    private $nbQuestion;
    private $i;

    public function __construct($nbQuestion = null) {
        $this->nbQuestion = $nbQuestion;
        $this->i = 0;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['display'] == 1) {
            $this->createBuilder($builder, $options['question'], $options['em']);
        } else {
            $this->nbQuestion = $options['nbQuestion'];
            $question = $options['question'][$this->i];

            $reponse = new Reponse();
            foreach ($options['reponses'] as $reponseL) {
                if ($question == $reponseL->getQuestion()) {
                    $reponse = $reponseL;
                    break;
                }
            }
            $this->createBuilder($builder, $question, $reponse, $options['em']);

            /*foreach ($options['question'] as $question) {
                $reponse = new Reponse();
                foreach ($options['reponses'] as $reponseL) {
                    if ($question == $reponseL->getQuestion()) {
                        $reponse = $reponseL;
                        break;
                    }
                }
                $this->createBuilder($builder, $question, $reponse, $options['em']);
            }*/

            $this->i++;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question',
            'question' => null,
            'reponses' => null,
            'nbQuestion' => null,
            'em' => null,
            'display' => null
        ));
    }

    private function createBuilder(FormBuilderInterface $builder, Question $question, Reponse $reponse = null, $em) {
        if (!is_null($question)) {
            switch($question->getTypeQuestion()) {
                case 1:
                    $builder->add('description', TextareaType::class, array(
                        'data' => $reponse->getDescription()
                    ));
                    break;
                case 2:
                    $builder->add('choix', ChoiceType::class, array(
                        'choices' => $this->fillChoix($question, $em),
                        'multiple' => false,
                        'expanded' => true,
                        'data' => $reponse->getId()
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