<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');

        $form = $this->createForm(UserType::class);

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render(':default:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $user->setSalt(md5(uniqid()));

                $encoder = $this->get('security.password_encoder');
                $password = $encoder->encodePassword($user, $form->get('password')->getData());
                $user->setPassword($password);

                $role = $this->getDoctrine()->getRepository('AppBundle:Role')->findOneByName('ROLE_USER');

                $user->setUserRole($role);

                $this->getDoctrine()->getEntityManager()->persist($user);
                $this->getDoctrine()->getEntityManager()->flush();

                $this->addFlash('register.success', $this->get('translator')->trans('message.flash.register.success'));

                return $this->redirectToRoute('login', array('_fragment' => 'signin'));
            }
        }

        return $this->render(':default:login.html.twig', array(
            'last_username' => null,
            'error' => null,
            'form' => $form->createView()
        ));
    }
}