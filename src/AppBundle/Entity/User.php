<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use AppBundle\Entity\Role;

/**
 * AppBundle\Entity\User
 *
 * @Vich\Uploadable
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity( fields={"username"}, message="form.error.unique.username")
 * @UniqueEntity( fields={"email"}, message="form.error.unique.email")
 */
class User implements UserInterface, AdvancedUserInterface, \Serializable
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $password
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string $salt
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var string $username
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string $name
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $surname
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     * )
     * @Assert\NotBlank()
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string $email
     * @Assert\Length(
     *      min = 1,
     *      max = 255,
     * )
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @var string $image
     * @ORM\Column(name="image_name", type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string $url
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var boolean $active
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var Int $num_logins
     * @ORM\Column(name="num_logins", type="integer")
     */
    private $numLogins;

    /**
     * @var datetime $last_login
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var datetime $creationDate
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $createDate;

    /**
     * @var datetime $modifiedDate
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedDate;


    /**
     * @var Role $userRole
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Role", inversedBy="users")
     */
    private $userRole;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createDate = new \DateTime();
        $this->modifiedDate = new \DateTime();
    }

    /**
     * Returns the user id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the user email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the user email
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the username
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Returns the user password codified
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the user password
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Returns the user salt
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the user salt
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Returns the user first name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the user first name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Sets the user last name
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * Returns the user last name
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return User
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     *
     * @return User
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param integer $imageSize
     *
     * @return User
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Returns if the user is active
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Sets the user active status
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Returns how many times has logged the user in the system
     * @return int
     */
    public function getNumLogins()
    {
        return $this->numLogins;
    }

    /**
     * Sets how many times has logged the user in the system
     * @param integer $numLogins
     */
    public function setNumLogins($numLogins)
    {
        $this->numLogins = $numLogins;
    }

    /**
     * Returns an array with the user roles
     * @return array
     */
    public function getRoles()
    {
        $roles[] = $this->userRole;
        return $roles;
    }

    /**
     * Gives a role to the user
     * @param \AppBundle\Entity\Role $userRoles
     */
    public function setRole(Role $userRoles)
    {
        $this->userRole[] = $userRoles;
    }

    /**
     * Sets an array of roles to the user
     * @param array $roles
     */
    public function setUserRoles($roles)
    {
        $this->userRole = $roles;
    }

    /**
     * Returns the user creation date
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Sets the user creation date
     * @param \DateTime $createDate
     */
    public function setCreateDate(\DateTime $createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * Returns the last time that the user was modified
     * @return \DateTime
     */
    function getModifiedAt()
    {
        return $this->modifiedDate;
    }

    /**
     * Sets the last time that the user was modified
     * @param \Datetime $modifiedDate
     */
    function setModifiedAt(\Datetime $modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
    }


    /**
     * Returns the last time that the user logged into the system
     * @return \DateTime
     */
    function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Sets the last time that the user logged into the system
     * @param \DateTime $lastLogin
     */
    function setLastLogin(\DateTime $lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    public function eraseCredentials()
    {
        return true;
    }

    /**
     * Serializes the content of the current User object
     * @return string
     */
    public function serialize()
    {
        return \json_encode(array($this->email, $this->password, $this->salt, $this->userRole, $this->id));
    }

    /**
     * Unserializes the given string in the current User object
     * @param serialized
     */
    public function unserialize($serialized)
    {
        list($this->email, $this->password, $this->salt, $this->userRole, $this->id) = \json_decode($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive();
    }

    /**
     * @ORM\PrePersist
     */
    function prePersistValues()
    {
        $this->setCreateDate(new \DateTime());
        $this->setModifiedAt(new \DateTime());
        $this->setNumLogins(0);
        $this->setActive(true);
    }

    /**
     * @ORM\PreUpdate
     */
    function preUpdateValues()
    {
        $this->modified_at = new \DateTime();
    }

    /**
     * Get active
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set modifiedDate
     * @param \DateTime $modifiedDate
     * @return User
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
        return $this;
    }

    /**
     * Get modifiedDate
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set userRole
     * @param \AppBundle\Entity\Role $userRole
     * @return User
     */
    public function setUserRole(Role $userRole = null)
    {
        $this->userRole = $userRole;
        return $this;
    }

    /**
     * Get userRole
     * @return \AppBundle\Entity\Role
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    public function hasRole($roleName)
    {
        return ($this->getUserRole()->getName() == $roleName);
    }

    public function __toString()
    {
        return $this->getName() . ' ' . $this->getSurname();
    }
}