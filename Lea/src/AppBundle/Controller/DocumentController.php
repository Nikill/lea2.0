<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/document")
 */
class DocumentController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="document_index")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {

        $arrayform = $this->newAction($request);

        $documents = $this->getDoctrine()->getRepository('AppBundle:Document')->findAll();
        $arrayform['documents'] = $documents;

        return $arrayform;
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
        $arrayform = $this->get('app.Document.manager')->edit($request, $id);
        $typesDocument = $this->getDoctrine()->getRepository('AppBundle:TypeDocument')->findAll();
        $arrayform['typesDocument'] = $typesDocument;
        return $arrayform;
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

    /**
     * @Template("AppBundle:Document:index.html.twig")
     * @Route("/save/{id}", name="document_save")
     * @param Request $request
     * @return array
     */
    public function saveAction(Request $request, $id)
    {
        $arrayform = $this->get('app.Document.manager')->edit($request, $id);
        $documents = $this->getDoctrine()->getRepository('AppBundle:Document')->findAll();
        $arrayform['documents'] = $documents;

        return $arrayform ;
    }
}