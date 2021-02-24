<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("username", message="Ce pseudonyme est déjà pris")
 * @UniqueEntity("email", message="Cette adresse mail est déjà associée à un compte")
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="vous devez entrer votre prénom")
     * @Assert\Length(
     *     min=3,
     *     max=45,
     *     minMessage="Votre prénom doit contenir au minimum {{ limit }} caractères",
     *     maxMessage="VVotre prénom doit contenir au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=45)
     */
    private $firstname;

    /**
     * @Assert\NotBlank(message="Vous devez saisir votre prénom")
     * @Assert\Length(
     *     min=3,
     *     max=45,
     *     minMessage="Votre nom doit contenir au minimum {{ limit }} caractères",
     *     maxMessage="VVotre nom doit contenir au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=45)
     */
    private $lastname;

    /**
     * @Assert\NotBlank(message="Vous devez saisir votre prénom")
     * @Assert\Length(
     *     min=3,
     *     max=45,
     *     minMessage="Votre pseudonyme doit contenir au minimum {{ limit }} caractères",
     *     maxMessage="VVotre pseudonyme doit contenir au maximum {{ limit }} caractères",
     * )
     * @ORM\Column(type="string", length=45)
     */
    private $username;

    /**
     * @Assert\NotBlank(message="Vous devez saisir une adresse mail")
     * @Assert\Email(message="L'adresse mail n'est pas valide")
     * @ORM\Column(type="string", length=95)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank(message="Vous devez saisir un mot de passe", groups={"registration"})
     * @Assert\Length(
     *     min=8,
     *     max=30,
     *     minMessage="Votre mot de passe doit contenir au minimum {{ limit }} caractères",
     *     maxMessage="Votre mot de passe doit contenir au maximum {{ limit }} caractères",
     * )
     * @Assert\NotCompromisedPassword(message="Ce mot de passe a déjà été compromis")
     */
    private $plainPassword;

    /**
     * @Assert\IsTrue(message="Vous devez accpeter les CGU")
     */
    private $CGU;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="user")
     */
    private $products;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tokenExpiredAt;

    public function __construct()
    {

        $this->createdAt = new \DateTime();
        $this->enabled = true;
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getCGU(): ?bool
    {
       
        return $this->CGU;
    }

    public function setCGU(bool $CGU): self
    {
        $this->CGU = $CGU;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getTokenExpiredAt(): ?\DateTimeInterface
    {
        return $this->tokenExpiredAt;
    }

    public function setTokenExpiredAt(?\DateTimeInterface $tokenExpiredAt): self
    {
        $this->tokenExpiredAt = $tokenExpiredAt;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function initCreatedAt()
    {
        $this->setCreatedAt( new DateTime() );
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials(){}

}
