<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\Image\ImageType;
use AppBundle\Form\User\UserDetailType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin/", name="admin_home")
     */
    public function homeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(':admin/pages:dashboard.html.twig');
    }

    /**
     * @Route("/admin/profile/", name="admin_profile")
     */
    public function profileAction(Request $request)
    {
        $images = $this->getDoctrine()->getRepository('AppBundle:Image')->findLastUserImages($this->getUser());

        return $this->render(':admin/pages:profile.html.twig', array(
            'images' => $images,
        ));
    }

    /**
     * @Route("/admin/profile/edit", name="admin_profile_edit")
     */
    public function profileEditAction(Request $request)
    {
        $form = $this->createForm(UserDetailType::class, $this->getUser());

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->getDoctrine()->getEntityManager()->persist($this->getUser());
                $this->getDoctrine()->getEntityManager()->flush();

                $this->addFlash('register.success', $this->get('translator')->trans('message.flash.edit.user.success'));

                return $this->redirectToRoute('admin_profile');
            }
        }

        return $this->render(':admin/pages:profile-edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/images/", name="admin_images")
     */
    public function ImagesAction(Request $request)
    {
        $images = $this->getDoctrine()->getRepository('AppBundle:Image')->findLastUserImages($this->getUser());

        return $this->render(':admin/pages:images.html.twig', array(
            'images' => $images,
        ));
    }

    /**
     * @Route("/admin/images/create", name="admin_images_create")
     */
    public function imageCreateAction(Request $request)
    {
        $image = new Image();
        $image->setUser($this->getUser());

        $form = $this->createForm(ImageType::class, $image);

        if ($request->getMethod() == 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->getDoctrine()->getEntityManager()->persist($image);
                $this->getDoctrine()->getEntityManager()->flush();

                $this->addFlash('image.success', $this->get('translator')->trans('message.flash.create.image.success'));

                return $this->redirectToRoute('admin_images');
            }
        }

        return $this->render(':admin/pages:images-create.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
