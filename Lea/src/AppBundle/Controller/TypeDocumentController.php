<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/typeDocument")
 */
class TypeDocumentController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="typeDocument_index")
     * @return array
     */
    public function indexAction(Request $request)
    {
        $arrayform = $this->get('app.TypeDocument.manager')->create($request);
        $typesDocument = $this->getDoctrine()->getRepository('AppBundle:TypeDocument')->findAll();
        $arrayform['typesDocument'] = $typesDocument;

        return $arrayform;
    }

    /**
     * @Template()
     * @Route("/new", name="typeDocument_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.TypeDocument.manager')->create($request);
    }

    /**
     * @Template()
     * @Route("/{id}/edit", name="typeDocument_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.TypeDocument.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/{id}/delete", name="typeDocument_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.TypeDocument.manager')->delete($request, $id);
    }
}