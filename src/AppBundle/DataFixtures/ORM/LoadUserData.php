<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements  OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function load(ObjectManager $manager)
    {
        $role = $manager->getRepository('AppBundle:Role')->findOneByName('ROLE_ADMIN');

        $user = new User();
        $user->setName('Sr.');
        $user->setSurname('admin');
        $user->setUsername('admin');
        $user->setEmail('mail@mail.com');
        $user->setUserRole($role);
        $user->setSalt(md5(uniqid()));

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'secret');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}