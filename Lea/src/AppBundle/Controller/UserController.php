<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/user")
 */
class UserController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="user_index")
     * @return array
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        return array('users' => $users);
    }

    /**
     * @Template()
     * @Route("/new", name="user_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.user.manager')->create($request);
    }

    /**
     * @Template()
     * @Route("/{id}/edit", name="user_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.user.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/{id}/delete", name="user_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.user.manager')->delete($request, $id);
    }
}