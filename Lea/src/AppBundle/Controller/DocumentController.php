<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/document")
 */
class DocumentController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="document_index")
     * @return array
     */
    public function indexAction()
    {
        $documents = $this->getDoctrine()->getRepository('AppBundle:Document')->findAll();
        return array('documents' => $documents);
    }

    /**
     * @Template()
     * @Route("/new", name="document_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.Document.manager')->create($request);
    }

    /**
     * @Template()
     * @Route("/{id}/edit", name="document_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.Document.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/{id}/delete", name="document_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.Document.manager')->delete($request, $id);
    }
}