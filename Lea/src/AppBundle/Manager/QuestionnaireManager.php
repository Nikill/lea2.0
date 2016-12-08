<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Contrat;
use AppBundle\Entity\Question;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\Questionnaire_Individualise;
use AppBundle\Entity\Reponse;
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
     * @param User $userActuel
     * @return mixed
     */
    public function findByUser(User $userActuel) {
        $questionnaires = new ArrayCollection();

        $contrats = $this->em->getRepository('AppBundle:Contrat')->findAll();
        $contratsUser = new ArrayCollection();
        foreach ($contrats as $contrat) {
            foreach ($contrat->getUsers() as $user) {
                if ($user == $userActuel) {
                    $contratsUser->add($contrat);
                    break;
                }
            }
        }

        foreach ($contratsUser as $contrat) {
            $yearDD = $contrat->getDateDebut()->format('Y');
            $yearDF = $contrat->getDateFin()->format('Y');

            $n = $yearDF - $yearDD;
            for ($i=0; $i<$n; $i++) {
                $fyearDD = $yearDD + $i;
                $lyearDD = $fyearDD + 1;
                $questionnaires[$fyearDD.'-'.$lyearDD] = $this->findQuestionnaires($contrat, $i);
            }
        }

        return $questionnaires;
    }

    private function findQuestionnaires(Contrat $contrat, $i) {
        $fyearDD = $contrat->getDateDebut()->format('Y') + $i;
        $lyearDD = $fyearDD + 1;

        $fyearDD = $fyearDD.'-09-01'; $lyearDD = $lyearDD.'-08-31';

        $er = $this->em->getRepository('AppBundle:Questionnaire');

        $results = $er->createQueryBuilder('q');
        $results -> leftJoin('q.promotions', 'p');

        $results -> where($results->expr()->between('q.dateOuverture', ':fyear', ':lyear'),
            $results->expr()->eq('p.id', ':promotion'));
        $results -> setParameter('fyear', $fyearDD);
        $results -> setParameter('lyear', $lyearDD);
        $results -> setParameter('promotion', $contrat->getPromotion()->getId());
        $results -> orderby('q.type', 'ASC');

        $results = $results->getQuery();
        $results = $results->getResult();

        $choices = array();
        foreach($results as $questionnaire){
            $choices[$questionnaire->getId()] = $questionnaire;
        }

        return $choices;
    }

    /**
     * @param User $userActuel
     * @param $role
     * @return mixed
     */
    public function findQuestionnairesNotCompletedByUser(User $userActuel, $role) {
        return $this->em->getRepository('AppBundle:Questionnaire_Individualise')->findQuestionnairesAcompleter($userActuel, $role);
    }

    /**
     * @param Questionnaire $questionnaire
     * @param User $user
     * @return mixed
     */
    public function findReponsesOfQuestionnaire(Questionnaire $questionnaire, User $user) {
        return $this->em->getRepository('AppBundle:Reponse')->findReponses($questionnaire, $user);
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
     * @param $user
     * @return RedirectResponse
     */
    public function display(Request $request, $id, User $user)
    {
        $questionnaire = $this->em->getRepository('AppBundle:Questionnaire')->find($id);
        if ($request->request->get('display_questionnaire') != null) {
            $contrats = $this->em->getRepository('AppBundle:Contrat')->findAll();
            $contratsUser = new ArrayCollection();
            foreach ($contrats as $contrat) {
                foreach ($contrat->getUsers() as $userWI) {
                    if ($user == $userWI) {
                        $contratsUser->add($contrat);
                        break;
                    }
                }
            }

            $this->saveAnswers($request, $user, $contratsUser, $questionnaire);
            if (isset($request->request->get('display_questionnaire')['validate'])) {
                $this->validateAnswers($request, $user, $contratsUser, $questionnaire);
            }
            return $this->redirect('homepage');
        } else {
            return $this->handleForm($request, $questionnaire, $user, "display");
        }
    }

    /**
     * Sauvegarde les réponses
     * @param Request $request
     * @param User $user
     * @param ArrayCollection $contratsUser
     * @param Questionnaire $questionnaire
     * @return array|RedirectResponse
     */
    public function saveAnswers(Request $request, User $user, ArrayCollection $contratsUser, Questionnaire $questionnaire)
    {
        $questionnaireIndividualise = $this->em->getRepository('AppBundle:Questionnaire_Individualise')->findOneBy(array('questionnaire' => $questionnaire, 'contrat' => $contratsUser->get(0)));

        if ($questionnaireIndividualise == null) {
            $questionnaireIndividualise = new Questionnaire_Individualise();
            $questionnaireIndividualise->setContrat($contratsUser->get(0));
            $questionnaireIndividualise->setQuestionnaire($questionnaire);
            $questionnaireIndividualise->setSignatureEtudiant(0);
            $questionnaireIndividualise->setSignatureMap(0);
            $questionnaireIndividualise->setSignatureTuteur(0);

            $this->persistAndFlush($questionnaireIndividualise);
        }

        $role=0;
        foreach ($user->getRoles() as $roleL) {
            switch ($roleL) {
                case "ROLE_ETUDIANT":
                    $role=1;
                    break;
                case "ROLE_TUTEUR":
                    $role=2;
                    break;
                case "ROLE_MAP":
                    $role=3;
                    break;
            }
        }

        $i=0;
        $reponses = new ArrayCollection($request->request->get('display_questionnaire')['questions']);
        foreach ($questionnaire->getQuestions() as $question) {
            $reponse = $this->em->getRepository('AppBundle:Reponse')->findOneBy(array('questionnaire_individualise' => $questionnaireIndividualise, 'question' => $question));
            if ($reponse == null) {
                $reponse = new Reponse();
                $reponse->setQuestionnaireIndividualise($questionnaireIndividualise);
                $reponse->setQuestion($question);

                $this->persistAndFlush($reponse);
            }

            if ($question->getCible() == $role) {
                foreach ($reponses[$i] as $reponseL) {
                    if ($question->getTypeQuestion() == 2) {
                        switch ($reponseL) {
                            case 0:
                                $value = "Défavorable";
                                break;
                            case 1:
                                $value = "Neutre";
                                break;
                            case 2:
                                $value = "Bon";
                                break;
                            case 3:
                                $value = "Favorable";
                                break;
                            case 4:
                                $value = "Très favorable";
                                break;
                        }
                        $reponse->setDescription($value);
                        /*$k = 0;
                        foreach ($question->getChoix() as $choix) {
                            if ($descriptionRQ == $k) {
                                $reponse->setDescription($choix->getDescription());
                                break;
                            }
                            $k++;
                        }*/
                    } else {
                        $reponse->setDescription($reponseL);
                    }
                    $this->persistAndFlush($reponse);
                }
            }
            $i++;
        }

        return $this->handleForm($request, $questionnaire);
    }

    /**
     * Valider un questionnaire
     * @param Request $request
     * @param User $user
     * @param ArrayCollection $contratsUser
     * @param Questionnaire $questionnaire
     * @return array|RedirectResponse
     */
    public function validateAnswers(Request $request, User $user, ArrayCollection $contratsUser, Questionnaire $questionnaire) {
        $questionnaireIndividualise = $this->em->getRepository('AppBundle:Questionnaire_Individualise')->findOneBy(array('questionnaire' => $questionnaire, 'contrat' => $contratsUser->get(0)));

        $roles = new ArrayCollection($user->getRoles());
        foreach ($roles as $role) {
            switch ($role) {
                case "ROLE_ETUDIANT":
                    $questionnaireIndividualise->setSignatureEtudiant(1);
                    break;
                case "ROLE_TUTEUR":
                    $questionnaireIndividualise->setSignatureTuteur(1);
                    break;
                case "ROLE_MAP":
                    $questionnaireIndividualise->setSignatureMap(1);
                    break;
            }
            $this->persistAndFlush($questionnaireIndividualise);
        }

        return $this->handleForm($request, $questionnaire);
    }

    /**
     * @param Request $request
     * @param Questionnaire $questionnaire
     * @param User $user
     * @param String $option
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, Questionnaire $questionnaire, User $user = null, $option = null)
    {
        if (!is_null($option) && $option == 'display') {
            $questions = $questionnaire->getQuestions();
            $questionnaireIndividualise = $this->em->getRepository('AppBundle:Questionnaire_Individualise')->findOneBy(array('questionnaire' => $questionnaire, 'contrat' => $user->getContrats()->get(0)));
            if ($questionnaireIndividualise != null) {
                $reponses = $this->findReponsesOfQuestionnaire($questionnaire, $user);
            } else {
                $reponses = array();
                for ($i=0; $i<sizeof($questions); $i++) {
                    $reponses[$i] = new Reponse();
                }
            }
            $form = $this->formFactory->create(DisplayQuestionnaireType::class, $questionnaire, array('questionnaire' => $questionnaire,
                'questions' => $questions, 'reponses' => $reponses, 'em' => $this->em));
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
            $form = $this->formFactory->create(QuestionnaireType::class, new Questionnaire());
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