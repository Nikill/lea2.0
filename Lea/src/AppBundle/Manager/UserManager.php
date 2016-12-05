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
        $user = $this->userManager->createUser();
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
        return $this->redirect('user_index');
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

        return $this->handleBaseForm($request, $form, $user, "homepage");
    }

    /**
     * @param Request $request
     * @param Form $form
     * @param $user
     * @param $path
     * @return array|RedirectResponse
     * @internal param $entity
     */
    protected function handleBaseForm(Request $request, Form $form, $user, $path)
    {
        // handle request bind form to password
        $oldPass = $user->getPassword();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $userConnecte = $this->token->getToken()->getUser();

            $path = (in_array("ROLE_SUPER_ADMIN", $userConnecte->getRoles())) ? "user_index" : $path = "homepage";

            // TODO: OMFG ===============
            if($user->getId())
            {
                // update existing user through FOSUser manager method
                $user->setPassword($oldPass);
                $this->editRole($request, $user);

            }else {
                //create a fresh user from form data
                $this->registerUser($request, $user);
            }

            // any case, redirect to users list
            return new RedirectResponse($this->router->generate($path));

        }
        return array('form' => $form->createView());
    }

    /**
     * @param Request $request
     * @param $entity
     * @return bool
     */
    private function registerUser(Request $request, User $entity)
    {
        $emailExist = $this->userManager->findUserByEmail($entity->getEmail());

        if($emailExist){
            return false;
        }

        $user = $this->userManager->createUser();
        $user->setUsername($entity->getUsername());
        $user->setUsernameCanonical($entity->getUsername());
        $user->setEmail($entity->getEmail());
        $user->setEmailCanonical($entity->getEmail());
        $user->setEnabled(true);
        $user->setPlainPassword($entity->getPassword());
        $user->setNom($entity->getNom());
        $user->setPrenom($entity->getPrenom());
        $user->setAdresse($entity->getAdresse());
        $user->setVille($entity->getVille());
        $user->setCodePostal($entity->getCodePostal());
        $user->setTelephoneFixe($entity->getTelephoneFixe());
        $user->setTelephonePortable($entity->getTelephonePortable());
        $user->setFax($entity->getFax());
        $user->setDateNaissance($entity->getDateNaissance());
        $user->setEstHandicape($entity->getEstHandicape());

        $this->editRole($request, $user);

        return true;
    }
    
    public function editRole(Request $request, $user)
    {
        // Getting the variable of the form
        $valueUser = $request->request->get('user');
        // Changing the role of the user
        $user->setRoles($valueUser['roles']);
        // set plain password here to allow updateUser method to hash it
        // Updating the user
        $this->userManager->updateUser($user);
    }
}