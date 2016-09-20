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
        //$user = new User();
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
            if($entity instanceof User)
            {
                // edition and user already exist

                // update existing user throught FOSUser manager method
                $entity->setPlainPassword($entity->getPassword());
                $this->userManager->updateUser($entity);

            }else {
                //create a fresh user from form datas
                $this->registerUser($entity->getEmail(), $entity->getUsername(), $entity->getNom(), $entity->getPrenom(), $entity->getAdresse(), $entity->getVille(), $entity->getTelephoneFix(),
                    $entity->getTelephonePortable(), $entity->getFax(), $entity->getDateNaissance(), $entity->getEstHandicape());
            }

            // any case, redirect to users list
            return new RedirectResponse($this->router->generate($path));

        }
        return array('form' => $form->createView());
    }


    /**
     * @param $email
     * @param $username
     * @return bool
     */
    private function registerUser($email, $username, $nom, $prenom, $adresse, $ville, $telephoneFix, $telephonePortable, $fax, $dateNaissance, $estHandicape)
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
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setAdresse($adresse);
        $user->setVille($ville);
        $user->setTelephoneFix($telephoneFix);
        $user->setTelephonePortable($telephonePortable);
        $user->setFax($fax);
        $user->setDateNaissance($dateNaissance);
        $user->setEstHandicape($estHandicape);

        $this->userManager->updateUser($user, false);
        $this->persistAndFlush($user);

        return true;
    }
}