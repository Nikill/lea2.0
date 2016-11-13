<?php

namespace AppBundle\Manager;

use AppBundle\Entity\AnneeScolaire;
use AppBundle\Form\AnneeScolaireType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AnneeScolaireManager extends BaseManager
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
        return $this->em->getRepository('AppBundle:AnneeScolaire')->findOneBy(array('id' => $id));
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->em->getRepository('AppBundle:AnneeScolaire')->findAll();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $anneeScolaire = new AnneeScolaire();
        return $this->handleForm($request, $anneeScolaire);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        $anneeScolaire = new AnneeScolaire();
        return $this->handleForm($request, $anneeScolaire);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $anneeScolaire = $this->em->getRepository('AppBundle:AnneeScolaire')->find($id);
        return $this->handleForm($request, $anneeScolaire);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $anneeScolaire = $this->em->getRepository('AppBundle:AnneeScolaire')->find($id);
        $this->removeAndFlush($anneeScolaire);
        return $this->redirect('anneeScolaire_index');
    }

    /**
     * @param Request $request
     * @param AnneeScolaire $anneeScolaire
     * @return array|RedirectResponse
     */
    public function handleForm(Request $request, AnneeScolaire $anneeScolaire)
    {
        $form = $this->formFactory->create(AnneeScolaireType::class, $anneeScolaire);
        return $this->handleBaseForm($request, $form, $anneeScolaire, "anneeScolaire_index");
    }
}