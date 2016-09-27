<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Question;
use AppBundle\Form\QuestionType;
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
     * @param Question $question
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, Question $question)
    {
        $form = $this->formFactory->create(QuestionType::class, $question);
        return $this->handleBaseForm($request, $form, $question, "question_index");
    }
}