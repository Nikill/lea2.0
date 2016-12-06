<?php

namespace AppBundle\Manager;

use AppBundle\Entity\TypeDocument;
use AppBundle\Form\TypeDocumentType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class TypeDocumentManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:TypeDocument')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('AppBundle:TypeDocument')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $typeDocument = new TypeDocument();
        return $this->handleForm($request, $typeDocument);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $typeDocument = new TypeDocument();
        return $this->handleForm($request, $typeDocument);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $typeDocument = $this->em->getRepository('AppBundle:TypeDocument')->find($id);
        return $this->handleForm($request, $typeDocument);
        $form = $this->formFactory->create(TypeDocumentType::class, $typeDocument);
        $form->handleRequest($request);

        $this->persistAndFlush($entity);
        $form = $this->formFactory->create(TypeDocumentType::class, new TypeDocument());

        return array('form' => $form->createView());
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($request, $id)
    {
        $typeDocument = $this->em->getRepository('AppBundle:TypeDocument')->find($id);
        $this->removeAndFlush($typeDocument);

        return $this->redirect('typeDocument_index');
    }

    /**
     * @param Request $request
     * @param TypeDocument $typeDocument
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, TypeDocument $typeDocument)
    {
        $form = $this->formFactory->create(TypeDocumentType::class, $typeDocument);
        return $this->handleBaseForm($request, $form, $typeDocument, "typeDocument_index");
    }

    protected function handleBaseForm(Request $request, Form $form, $entity, $path)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlush($entity);
            $form = $this->formFactory->create(TypeDocumentType::class, new TypeDocument());
        }
        return array('form' => $form->createView());
    }

}