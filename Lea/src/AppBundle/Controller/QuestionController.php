<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
     * @Route("/id={id}/edit", name="question_edit")
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
     * @Route("/id={id}/delete", name="question_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.question.manager')->delete($request, $id);
    }

    /**
     * @Template("AppBundle:Question:edit.html.twig")
     * @Route("/id={id}&id_choix={id_choix}/add", name="choix_add")
     * @param Request $request
     * @param $id
     * @param $id_choix
     * @return array
     */
    public function addAction(Request $request, $id, $id_choix)
    {
        return $this->get('app.question.manager')->add($request, $id, $id_choix);
    }

    /**
     * @Template("AppBundle:Question:edit.html.twig")
     * @Route("/id={id}&id_choix={id_choix}/remove", name="choix_remove")
     * @param Request $request
     * @param $id
     * @param $id_choix
     * @return array
     */
    public function removeAction(Request $request, $id, $id_choix)
    {
        return $this->get('app.question.manager')->remove($request, $id, $id_choix);
    }

    /**
     * @Template("AppBundle:Question:display.html.twig")
     * @Route("/id={id}/display", name="question_display")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function displayAction(Request $request, $id)
    {
        return $this->get('app.question.manager')->display($request, $id);
    }
}