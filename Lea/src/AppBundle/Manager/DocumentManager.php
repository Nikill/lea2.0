<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

class DocumentManager extends BaseManager
{
    private $container;
    private $fileSystem;
    
    /**
     * CategoryManager constructor.
     * @param $em
     * @param $formFactory
     * @param Router $router
     * @param $container
     */
    public function __construct($em, $formFactory, Router $router, $container)
    {
        parent::__construct($em, $formFactory, $router);
        $this->container = $container;
        $this->fileSystem = new Filesystem();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->em->getRepository('AppBundle:Document')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('AppBundle:Document')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $document = new Document();
        return $this->handleForm($request, $document);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $document = new Document();
        return $this->handleForm($request, $document);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $document = $this->em->getRepository('AppBundle:Document')->find($id);
        var_dump($document);

        return $this->handleForm($request, $document);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $document = $this->em->getRepository('AppBundle:Document')->find($id);
        $this->removeAndFlush($document);

        $file = $this->container->getParameter('upload_dir').'/'.$document->getNomFichier();
        if($document->getNomFichier() != null)
        {
            unlink($file);
        }

        return $this->redirect('document_index');
    }

    /**
     * @param Request $request
     * @param Document $document
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, Document $document)
    {

        $form = $this->formFactory->create(DocumentType::class, $document);
        return $this->handleBaseForm($request, $form, $document, "document_index");
    }

    protected function handleBaseForm(Request $request, Form $form, $entity, $path)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $entity->getFile();

            if($file)
            {
                // Delete olf file
                $oldFile = $this->container->getParameter('upload_dir').'/'.$entity->getNomFichier();
                if($entity->getNomFichier() != null)
                {
                    unlink($oldFile);
                }

                $fileName =  uniqid() . $file->getClientOriginalName();
                $file->move($this->container->getParameter('upload_dir'), $fileName);
                $entity->setNomFichier($fileName);
            }else {
                $entity->setNomFichier($entity->getNomFichier());
            }

            $this->persistAndFlush($entity);
            $form = $this->formFactory->create(DocumentType::class, new Document());
        }

        return array('form' => $form->createView(), 'entity' => $entity);
    }
}