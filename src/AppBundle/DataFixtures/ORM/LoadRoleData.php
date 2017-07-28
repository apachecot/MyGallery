<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements  OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $currentRoles = array('ROLE_USER', 'ROLE_ADMIN');
        
        foreach($currentRoles as $item){

            $manager->persist(new Role($item));
        }
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}