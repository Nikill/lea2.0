<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
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
            $nombreQuestionnaires = count($questionnaires);
            $this->get('session')->set('nombreQuestionnaires', $nombreQuestionnaires);
        }else{
            $roleUser='ROLE_SUPER_ADMIN';
        }

        foreach ($questionnaires as $key =>$questionnaire){

            if($questionnaire->getQuestionnaire()->getType()->getId()==3){
                if($questionnaire->getSignatureMap()==false){

                    unset($questionnaires[$key]);
                }
            }
        }

        if($roleUser == 'ROLE_ETUDIANT'){
            $contrats=$user->getContrats();
            $contrat= $contrats[0];
            $users = $contrat->getUsers();
            $map=new User();
            $tuteur=new User();
            foreach ($users as $user){
                $roles = $user->getRoles();
                foreach ($roles as $role) {
                    switch ($role) {
                        case "ROLE_TUTEUR":
                            $tuteur = $user;
                            break;
                        case "ROLE_MAP":
                            $map = $user;
                            break;
                    }
                }
            }

            $this->get('session')->set('tuteur', $tuteur);
            $this->get('session')->set('map', $map);
        }
        $this->get('session')->set('roleUser', $roleUser);

        return array('questionnairesAcompleter' => $questionnaires);
    }
}