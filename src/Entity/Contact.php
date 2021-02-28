<?php
namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     *
     */
    private $name;

    /**
     * @var string|null
     * @Assert\Regex("/[0-9]/")
     */
    private $phone;

    /**
     * @Assert\NotBlank(message="Vous devez saisir une adresse mail")
     * @Assert\Email(message="L'adresse mail n'est pas valide")
     * @ORM\Column(type="string", length=95)
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Vous devez saisir un message")
     * @Assert\Length(
     *     min=30,
     *     max=300,
     *     minMessage="Votre message doit contenir au minimum {{ limit }} caractères",
     *     maxMessage="Votre message doit contenir au maximum {{ limit }} caractères",
     * )
     */
     
    private $message;


    
    public function getName(): ?string
    {
        return $this->name;
    }

    
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    
    public function getPhone(): ?string
    {
        return $this->phone;
    }

   
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
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

   
    public function getMessage(): ?string
    {
        return $this->message;
    }

    
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

}