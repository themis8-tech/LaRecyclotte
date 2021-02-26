<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Zipcode;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Vous devez saisir un nom !")
     * @Assert\Length(
     *     min=5,
     *     max=60,
     *     minMessage="Le titre doit contenir au moins {{ limit }} caractères !")
     *     
     * 
     * @Assert\Regex("/^[0-9]+$/", match=false, message="Le titre doit contenir des lettres !")
     * @ORM\Column(type="string", length=60)
     */
    private $title;

    /**
     * @Assert\File(
     *     maxSize = "2024k",
     *     mimeTypes = {"image/jpeg", "image/png", "image/webp", "image/bmp"},
     *     mimeTypesMessage = "La phot doit être au format : png, jpeg, webp, bmp, webp")
     *
     * @Assert\NotBlank(message="Vous devez joindre une photos !")
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @Assert\NotBlank(message=" Vous devez indiquer la ville !")
     * @Assert\Regex("/[^a-z]+$/", match=false, message="La ville doit contenir uniquement des lettres  !")
     * @ORM\Column(type="string", length=100)
     */
    private $city;

    /**
     * @Assert\NotBlank(message=" Vous devez indiquer une déscription !")
     * @Assert\Length(
     *     min=20,
     *     minMessage="Le déscription doit contenir au moins {{ limit }} caractères !")
     *     
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\NotBlank(message="Vous devez saisir une date de début")
     * @Assert\GreaterThan("today", message="Vous ne pouvez pas choisir une date antérieur")
     * @ORM\Column(type="date")
     */
    private $endAt;

    /**
     * 
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @Assert\NotBlank(message="Indiquez la catégorie !")
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @Assert\NotBlank(message=" Vous devez indiquer l'état !")
     * @ORM\ManyToOne(targetEntity=State::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @Assert\NotBlank(message=" Vous devez indiquer le code postale !")
     * @ORM\ManyToOne(targetEntity=Zipcode::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $zipcode;

    public function __construct()
    {
  
        $this->enabled = true;
        
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZipcode(): ?Zipcode
    {
        return $this->zipcode;
    }

    public function setZipcode(?Zipcode $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }
    /**
     * @ORM\PrePersist
     */
    public function initCreatedAt()
    {
        $this->setCreatedAt( new DateTime() );
    }
}
