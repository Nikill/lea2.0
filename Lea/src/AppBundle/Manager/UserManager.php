<?php

namespace AppBundle\Manager;


use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class UserManager extends BaseManager
{
    protected $token;

    protected $userManager;

    /**
     * CategoryManager constructor.
     * @param $em
     * @param $formFactory
     * @param Router $router
     * @param $token
     * @param $fosUserManager
     */
    public function __construct($em, $formFactory, Router $router, $token, $fosUserManager)
    {
        parent::__construct($em, $formFactory, $router);
        $this->token = $token;
        $this->userManager = $fosUserManager;
    }

    public function findOneByName($name)
    {
        return $this->em->getRepository('AppBundle:User')->findOneByName($name);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $user = new User();
        return $this->handleForm($request, $user);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|RedirectResponse
     */
    public function edit(Request $request, $id)
    {
        $user = $this->em->getRepository('AppBundle:User')->find($id);
        return $this->handleForm($request, $user);
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $script = $this->em->getRepository('AppBundle:User')->find($id);
        $this->removeAndFlush($script);
        return $this->redirect('users_index');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return array|RedirectResponse
     * @internal param User $user
     */
    public function handleForm(Request $request, User $user)
    {
        $form = $this->formFactory->create(UserType::class, $user);
        return $this->handleBaseForm($request, $form, $user, "users_index");
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param $entity
     * @param $path
     * @return array|RedirectResponse
     */
    protected function handleBaseForm(Request $request, Form $form, $entity, $path)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $successRegister = $this->registerUser($entity->getEmail(), $entity->getUsername(), $entity->getPassword());

            if($successRegister)
            {
                // success
                //$this->persistAndFlush($entity);
                return new RedirectResponse($this->router->generate($path));
            }else{
                // fail register
                return new RedirectResponse($this->router->generate($path));
            }

        }
        return array('form' => $form->createView());
    }

    private function registerUser($email,$username)
    {
        $emailExist = $this->userManager->findUserByEmail($email);

        if($emailExist){
            return false;
        }

        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setUsernameCanonical($username);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setLocked(0);
        $user->setEnabled(1);
        $user->setPlainPassword("123");
        $this->userManager->updateUser($user);
        return true;
    }
}