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
     * @Route("/{id}/edit", name="questionnaire_edit")
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
     * @Route("/{id}/delete", name="questionnaire_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.questionnaire.manager')->delete($request, $id);
    }
}