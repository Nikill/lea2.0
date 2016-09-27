<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/question")
 */
class QuestionController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="question_index")
     * @return array
     */
    public function indexAction()
    {
        $questions = $this->get('app.question.manager')->findAll();
        return array('questions' => $questions);
    }

    /**
     * @Template()
     * @Route("/new", name="question_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.question.manager')->save($request);
    }

    /**
     * @Template()
     * @Route("/{id}/edit", name="question_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.question.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/{id}/delete", name="question_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.question.manager')->delete($request, $id);
    }
}