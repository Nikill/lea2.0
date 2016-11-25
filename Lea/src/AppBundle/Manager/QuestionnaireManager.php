<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\User;
use AppBundle\Form\DisplayQuestionnaireType;
use AppBundle\Form\QuestionnaireType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
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
     * @param User $user
     * @return mixed
     */
    public function findByUser(User $userActuel) {
        $questionnaires = $this->em->getRepository('AppBundle:Questionnaire')->findAll();

        $questionnairesUser = new ArrayCollection();
        foreach ($questionnaires as $questionnaire) {
            $find = false;
            foreach ($questionnaire->getPromotions() as $promotion) {
                foreach ($promotion->getContrats() as $contrat) {
                    foreach ($contrat->getUsers() as $user) {
                        if ($user == $userActuel) {
                            $questionnairesUser->add($questionnaire);
                            $find = true;
                            break;
                        }
                    }
                    if ($find) { break; }
                }
                if ($find) { break; }
            }
        }

        return $questionnairesUser;
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
     * @param $id
     * @param $id_question
     * @return RedirectResponse
     */
    public function add(Request $request, $id, $id_question)
    {
        $questionnaire = $this->em->getRepository('AppBundle:Questionnaire')->find($id);
        $question = $this->em->getRepository('AppBundle:Question')->find($id_question);

        $questionnaire->addQuestion($question);
        $this->persistAndFlush($questionnaire);
        return $this->handleForm($request, $questionnaire);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $id_question
     * @return RedirectResponse
     */
    public function remove(Request $request, $id, $id_question)
    {
        $questionnaire = $this->em->getRepository('AppBundle:Questionnaire')->find($id);
        $question = $this->em->getRepository('AppBundle:Question')->find($id_question);

        $questionnaire->removeQuestion($question);
        $this->persistAndFlush($questionnaire);
        return $this->handleForm($request, $questionnaire);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function display(Request $request, $id)
    {
        $questionnaire = $this->em->getRepository('AppBundle:Questionnaire')->find($id);
        return $this->handleForm($request, $questionnaire, "display");
    }

    /**
     * @param Request $request
     * @param Questionnaire $questionnaire
     * @param String $option
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, Questionnaire $questionnaire, $option = null)
    {
        if (!is_null($option) && $option == 'display') {
            $questions = $questionnaire->getQuestions();
            $form = $this->formFactory->create(DisplayQuestionnaireType::class, $questionnaire, array('questionnaire' => $questionnaire, 'questions' => $questions, 'em' => $this->em));
        } else {
            $form = $this->formFactory->create(QuestionnaireType::class, $questionnaire);
        }
        return $this->handleBaseForm($request, $form, $questionnaire, "questionnaire_index");
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
            return new RedirectResponse($this->router->generate("questionnaire_index"));
        }

        //Suppression des questions déjà présentes dans le questionnaire
        $questions = $this->em->getRepository('AppBundle:Question')->findByType($entity->getType());
        $questions = new ArrayCollection($questions);

        if (!is_null($entity->getQuestions())) {
            foreach ($questions as $question) {
                if ($entity->getQuestions()->contains($question)) {
                    $questions->removeElement($question);
                }
            }
        }

        return array('form' => $form->createView(), 'questionnaire' => $entity, 'questions' => $questions);
    }
}