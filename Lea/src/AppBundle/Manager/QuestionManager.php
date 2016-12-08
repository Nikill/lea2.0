<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Question;
use AppBundle\Form\DisplayQuestionType;
use AppBundle\Form\QuestionType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class QuestionManager extends BaseManager
{
    /**
     * CategoryManager constructor.
     * @param $em
     * @param $formFactory
     * @param Router $router
     */
    public function __construct($em, $formFactory, Router $router)
    {
        parent::__construct($em, $formFactory, $router);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->em->getRepository('AppBundle:Question')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('AppBundle:Question')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $question = new Question();
        return $this->handleForm($request, $question);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $question = $this->em->getRepository('AppBundle:Question')->find($id);
        return $this->handleForm($request, $question);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $question = $this->em->getRepository('AppBundle:Question')->find($id);
        $this->removeAndFlush($question);
        return $this->redirect('question_index');
    }

    /**
     * @param Request $request
     * @param $id
     * @param $id_choix
     * @return RedirectResponse
     */
    public function add(Request $request, $id, $id_choix)
    {
        $question = $this->em->getRepository('AppBundle:Question')->find($id);
        $choix = $this->em->getRepository('AppBundle:Choix')->find($id_choix);

        $question->addChoix($choix);
        $this->persistAndFlush($question);
        return $this->handleForm($request, $question);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $id_choix
     * @return RedirectResponse
     */
    public function remove(Request $request, $id, $id_choix)
    {
        $question = $this->em->getRepository('AppBundle:Question')->find($id);
        $choix = $this->em->getRepository('AppBundle:Choix')->find($id_choix);

        $question->removeChoix($choix);
        $this->persistAndFlush($question);
        return $this->handleForm($request, $question);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function display(Request $request, $id)
    {
        $question = $this->em->getRepository('AppBundle:Question')->find($id);
        return $this->handleForm($request, $question, "display");
    }

    /**
     * @param Request $request
     * @param Question $question
     * @param String $option
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, Question $question, $option = null)
    {
        if (!is_null($option) && $option == 'display') {
            $form = $this->formFactory->create(DisplayQuestionType::class, $question, array('question' => $question, 'em' => $this->em, 'display' => 1));
        } else {
            $form = $this->formFactory->create(QuestionType::class, $question);
        }
        return $this->handleBaseForm($request, $form, $question, "question_index");
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param $entity
     * @param $path
     * @return array|RedirectResponse
     */
    protected function handleBaseForm(Request $request, Form $form, $entity, $path)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlush($entity);
            $form = $this->formFactory->create(QuestionType::class, $entity);
        }

        //Suppression des choix déjà présents pour la question
        $choix = $this->em->getRepository('AppBundle:Choix')->findAll();
        $choix = new ArrayCollection($choix);

        if (!is_null($entity->getChoix())) {
            foreach ($choix as $choi) {
                if ($entity->getChoix()->contains($choi)) {
                    $choix->removeElement($choi);
                }
            }
        }

        return array('formQuestion' => $form->createView(), 'question' => $entity, 'choix' => $choix);
    }
}