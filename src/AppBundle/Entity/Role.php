<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity()
 */
class Role implements RoleInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=125)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="userRole")
     * */
    private $users;

    public function __construct($name)
    {
        $this->users = new ArrayCollection();
        $this->setName($name);
    }

    /**
     * Returns the role id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the role name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the role name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the role name
     * @return string
     */
    public function getRole()
    {
        return $this->getName();
    }

    /**
     * Returns the role name
     * @return string
     */
    public function __toString()
    {
        return $this->getRole();
    }

    /**
     * Add users
     *
     * @param \ET\FrontendBundle\Entity\User $user
     * @return Role
     */
    public function addUser(User $user)
    {
        $this->users->add($user);
        return $this;
    }

    /**
     * Remove user
     *
     * @param AppBundle\Entity\User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}