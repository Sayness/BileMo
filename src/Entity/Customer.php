<?php

namespace App\Entity;

use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use OpenApi\Annotations as OA;

/**
 * @ApiResource(formats={"json"})
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 *  @Hateoas\Relation("self", href = "expr('/api/customer/' ~ object.getId())"
 * , exclusion = @Hateoas\Exclusion(groups={"customer:read"}))
 * @Hateoas\Relation("list", href = "expr('/api/customers/",
 *  exclusion = @Hateoas\Exclusion(groups={"customer:read"}))
 * 
 * @OA\Schema
 */

class Customer implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"customer:read"})
     * @OA\Property(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"customer:read"})
     * @OA\Property(type="string",nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"customer:read"})
     * @OA\Property(type="string",nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true,unique=true)
     *@Serializer\Groups({"customer:read"})
     *@OA\Property(type="string",nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Serializer\Groups({"customer:read"})
     * @OA\Property(type="json",nullable=true)
     */
    private $roles = [];

    /**
     *  @var string The hashed password
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"customer:read"})
     * @OA\Property(type="string",nullable=true)
     */
    private $password;

    private $plainPassword;

   

 

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"customer:read"})
     * @OA\Property(type="string",nullable=true)
     */
    private $Company;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="customer")
     * @Serializer\Groups({"customer:read"})
     */
    private $User;

   


   


    public function __construct()
    {
        $this->Product = new ArrayCollection();
        $this->User = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
    
    /**
     * @see PasswordAuthenticatedUserInterface
     */

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }




 

    public function getCompany(): ?string
    {
        return $this->Company;
    }

    public function setCompany(?string $Company): self
    {
        $this->Company = $Company;

        return $this;
    }

     /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

  

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
            $user->setCustomer($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->User->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCustomer() === $this) {
                $user->setCustomer(null);
            }
        }

        return $this;
    }






  
   

    
}
