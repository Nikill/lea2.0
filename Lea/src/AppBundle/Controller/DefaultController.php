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
        $isTuteur = false;
        $isMap=false;
        $isEtudiant=false;
        foreach ($roles as $role) {
            if ($role == "ROLE_TUTEUR"){
                $isTuteur = true;
                break;
            }else if($role == "ROLE_MAP"){
                $isMap = true;
                break;
            }else if($role == "ROLE_ETUDIANT"){
                $isEtudiant=true;
            }
        }

        if ($isTuteur) {
            $questionnaires = $this->get('app.questionnaire.manager')->findQuestionnairesNotCompletedByUser($user, "signatureTuteur");
        }
        if($isMap){
            $questionnairesMap = $this->get('app.questionnaire.manager')->findQuestionnairesNotCompletedByUser($user, "signatureMap");
            $questionnaires = array_merge($questionnaires, $questionnairesMap);
        }
        if($isEtudiant){
            $questionnairesEtudiant = $this->get('app.questionnaire.manager')->findQuestionnairesNotCompletedByUser($user, "signatureEtudiant");
            $questionnaires= array_merge($questionnaires, $questionnairesEtudiant);
        }
        return array('questionnairesAcompleter' => $questionnaires);
    }
}