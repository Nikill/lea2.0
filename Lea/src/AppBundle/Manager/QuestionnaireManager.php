<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Questionnaire;
use AppBundle\Form\QuestionnaireType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:Questionnaire')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('AppBundle:Questionnaire')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $questionnaire = new Questionnaire();
        return $this->handleForm($request, $questionnaire);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $questionnaire = $this->em->getRepository('AppBundle:Questionnaire')->find($id);
        return $this->handleForm($request, $questionnaire);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $questionnaire = $this->em->getRepository('AppBundle:Questionnaire')->find($id);
        $this->removeAndFlush($questionnaire);
        return $this->redirect('questionnaire_index');
    }

    /**
     * @param Request $request
     * @param Questionnaire $questionnaire
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, Questionnaire $questionnaire)
    {
        $form = $this->formFactory->create(QuestionnaireType::class, $questionnaire);
        return $this->handleBaseForm($request, $form, $questionnaire, "questionnaire_index");
    }
}