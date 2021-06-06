<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer", indexes={@ORM\Index(name="address_id", columns={"address_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=100, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="login_email", type="string", length=150, nullable=false)
     */
    private $loginEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="login_pass", type="string", length=64, nullable=false, options={"fixed"=true})
     */
    private $loginPass;

    /**
     * @var bool
     *
     * @ORM\Column(name="login_activated", type="boolean", nullable=false)
     */
    private $loginActivated;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_num", type="string", length=20, nullable=false)
     */
    private $phoneNum;

    /**
     * @var \Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * })
     */
    private $address;

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getLoginEmail(): ?string
    {
        return $this->loginEmail;
    }

    public function setLoginEmail(string $loginEmail): self
    {
        $this->loginEmail = $loginEmail;

        return $this;
    }

    public function getLoginPass(): ?string
    {
        return $this->loginPass;
    }

    public function setLoginPass(string $loginPass): self
    {
        $this->loginPass = $loginPass;

        return $this;
    }

    public function getLoginActivated(): ?bool
    {
        return $this->loginActivated;
    }

    public function setLoginActivated(bool $loginActivated): self
    {
        $this->loginActivated = $loginActivated;

        return $this;
    }

    public function getPhoneNum(): ?string
    {
        return $this->phoneNum;
    }

    public function setPhoneNum(string $phoneNum): self
    {
        $this->phoneNum = $phoneNum;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }


}
