<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/question")
 */
class QuestionController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="questions_index")
     * @return array
     */
    public function indexAction()
    {
        $questions = $this->getDoctrine()->getRepository('AppBundle:Question')->findAll();
        return array('questions' => $questions);
    }
}