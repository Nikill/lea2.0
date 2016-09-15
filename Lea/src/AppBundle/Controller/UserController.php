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
     * @Route("/", name="users_index")
     * @return array
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        return array('users' => $users);
    }


    /**
     * @Route("/unapproved", name="user_unapproved")
     * @return array
     */
    public function unapprovedAction()
    {
        if ($this->getUser()->hasRole('ROLE_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();
            $users = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array('enabled' => false));

            foreach($users as $user)
            {
                $em->remove($user);
            }
            $em->flush();
        }else
        {
            // get all scripts done by the user
            $this->redirectToRoute('script_index');
        }
        return $this->redirectToRoute('users_index');
    }

    /**
     * @Template()
     * @Route("/new", name="users_create")
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        return $this->get('app.users.manager')->create($request);
    }

    /**
     * @Template()
     * @Route("/{id}/edit", name="users_edit")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return $this->get('app.users.manager')->edit($request, $id);
    }

    /**
     * @Template()
     * @Route("/{id}/delete", name="users_delete")
     * @param Request $request
     * @param $id
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->get('app.users.manager')->delete($request, $id);
    }
}