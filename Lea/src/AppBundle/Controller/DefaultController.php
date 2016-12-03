<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="homepage")
     * @return array
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $roles = new ArrayCollection($user->getRoles());
        $questionnaires=array();

        // Test si l'utilisateur est un responsable ou un admin
        $isInform = false;
        foreach ($roles as $role) {
            if ($role == "ROLE_TUTEUR" OR $role == "ROLE_MAP" OR $role == "ROLE_ETUDIANT") {
                $isInform = true;
                $roleUser=$role;
                break;
            }
        }

        if ($isInform) {
            $questionnaires = $this->get('app.questionnaire.manager')->findQuestionnairesNotCompletedByUser($user,$role);
        }
        $questionnaires = $this->get('app.questionnaire.manager')->findQuestionnairesNotCompletedByUser($user,$role);

        return array('questionnairesAcompleter' => $questionnaires);
    }
}