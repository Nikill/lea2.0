<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="homepage")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        return array();
    }
}
