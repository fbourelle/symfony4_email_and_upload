<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email",
 *     message="Email error"
 * )
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please provide a name !")
     * @Assert\Length(
     *     max="30",
     *     maxMessage="Your username is too long ! 30 max !",
     *     min="2",
     *     minMessage="2 chars minimum please ! You can do it better"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank(message="Please provide a firstname !")
     * @Assert\Length(
     *     max="30",
     *     maxMessage="Your firstname is too long ! 30 max !",
     *     min="1",
     *     minMessage="1 char minimum please ! You can do it better"
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @Assert\Email(message="Your email is not valid !")
     * @Assert\NotBlank(message="Please provide a email !")
     * @Assert\NotBlank(message="Please provide a email !")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Your email is too long ! 255 max !",
     *     min="2",
     *     minMessage="2 chars minimum please ! You can do it better"
     * )
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Assert\Image(
     *      maxSize = "1024k",
     *      maxSizeMessage = "The file is too big, max size : 1024k",
     *      mimeTypes = {"image/jpeg", "image/png", "image/jpg"},
     *      mimeTypesMessage="Please upload a valid image, type allowed = jpeg, png"
     * )
     * @ORM\Column(type="string", length=255, options={"default": "default_picture.jpg"})
     */
    private $picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }
}
