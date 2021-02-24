<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDisplay {

    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champs doit être rempli.")
     * @Assert\Length(min=2, max=90)
     */
    private $name;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champs doit être rempli.")
     * @Assert\Email(message="L'adresse mail n'est pas valide.")
     * @Assert\Length(min=2, max=95)
     */
    private $email;

    /**
     * @var string|null
     * @Assert\Regex("/[0-9]/")
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Ce champs doit être rempli.")
     * @Assert\Length(min=5)
     */
    private $message;

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return ContactDisplay
     */
    public function setName(string $name): ContactDisplay
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return ContactDisplay
     */
    public function setEmail(string $email): ContactDisplay
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return ContactDisplay
     */
    public function setPhone(string $phone): ContactDisplay
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return ContactDisplay
     */
    public function setMessage(string $message): ContactDisplay
    {
        $this->message = $message;

        return $this;
    }

}