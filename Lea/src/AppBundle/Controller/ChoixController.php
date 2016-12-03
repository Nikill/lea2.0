<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Choix;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/choix")
 */
class ChoixController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="choix_index")
     * @return array
     */
    public function indexAction()
    {
        $choix = $this->get('app.choix.manager')->findAll();
        return array('choix' => $choix);
    }

    /**
     * @Template()
     * @Route("/new", name="choix_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        $rang = $request->get('rang');
        $description = $request->get('description');

        $choix = new Choix();
        $choix->setRang($rang);
        $choix->setDescription($description);
        return $this->get('app.choix.manager')->saveAjax($choix);
    }

    /**
     * @Template()
     * @Route("/id={id}/edit", name="choix_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.choix.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/id={id}/delete", name="choix_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.choix.manager')->delete($request, $id);
    }
}