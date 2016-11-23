<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Choix;
use AppBundle\Form\ChoixType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ChoixManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:Choix')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('AppBundle:Choix')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $choix = new Choix();
        return $this->handleForm($request, $choix);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $choix = $this->em->getRepository('AppBundle:Choix')->find($id);
        return $this->handleForm($request, $choix);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $choix = $this->em->getRepository('AppBundle:Choix')->find($id);
        $this->removeAndFlush($choix);
        return $this->redirect('choix_index');
    }

    /**
     * @param Request $request
     * @param Choix $choix
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, Choix $choix)
    {
        $form = $this->formFactory->create(ChoixType::class, $choix);
        return $this->handleBaseForm($request, $form, $choix, "choix_index");
    }
}