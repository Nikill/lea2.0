<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/anneeScolaire")
 */
class AnneeScolaireController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="anneeScolaire_index")
     * @return array
     */
    public function indexAction()
    {
        $anneesScolaires = $this->getDoctrine()->getRepository('AppBundle:AnneeScolaire')->findAll();
        return array('anneesScolaires' => $anneesScolaires);
    }

    /**
     * @Template()
     * @Route("/new", name="anneeScolaire_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.AnneeScolaire.manager')->create($request);
    }

    /**
     * @Template()
     * @Route("/{id}/edit", name="anneeScolaire_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.AnneeScolaire.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/{id}/delete", name="anneeScolaire_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.AnneeScolaire.manager')->delete($request, $id);
    }
}