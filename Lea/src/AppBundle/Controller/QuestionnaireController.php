<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/questionnaire")
 */
class QuestionnaireController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="questionnaire_index")
     * @return array
     */
    public function indexAction()
    {
        $questionnaires = $this->get('app.questionnaire.manager')->findAll();
        return array('questionnaires' => $questionnaires);
    }

    /**
     * @Template()
     * @Route("/new", name="questionnaire_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.questionnaire.manager')->save($request);
    }

    /**
     * @Template()
     * @Route("/id={id}/edit", name="questionnaire_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.questionnaire.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/id={id}/delete", name="questionnaire_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.questionnaire.manager')->delete($request, $id);
    }

    /**
     * @Template("AppBundle:Questionnaire:edit.html.twig")
     * @Route("/id={id}&id_question={id_question}/add", name="question_add")
     * @param Request $request
     * @param $id
     * @param $id_question
     * @return array
     */
    public function addAction(Request $request, $id, $id_question)
    {
        return $this->get('app.questionnaire.manager')->add($request, $id, $id_question);
    }

    /**
     * @Template("AppBundle:Questionnaire:edit.html.twig")
     * @Route("/id={id}&id_question={id_question}/remove", name="question_remove")
     * @param Request $request
     * @param $id
     * @param $id_question
     * @return array
     */
    public function removeAction(Request $request, $id, $id_question)
    {
        return $this->get('app.questionnaire.manager')->remove($request, $id, $id_question);
    }

    /**
     * @Template("AppBundle:Questionnaire:display.html.twig")
     * @Route("/id={id}/display", name="questionnaire_display")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function displayAction(Request $request, $id)
    {
        return $this->get('app.questionnaire.manager')->display($request, $id);
    }
}