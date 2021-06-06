<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partner
 *
 * @ORM\Table(name="partner", indexes={@ORM\Index(name="address_id", columns={"address_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PartnerRepository")
 */
class Partner
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
     * @var bool
     *
     * @ORM\Column(name="pays_tax", type="boolean", nullable=false)
     */
    private $paysTax;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_acc", type="string", length=200, nullable=false)
     */
    private $bankAcc;

    /**
     * @var int
     *
     * @ORM\Column(name="variable_symbol", type="integer", nullable=false)
     */
    private $variableSymbol;

    /**
     * @var int
     *
     * @ORM\Column(name="ICO", type="integer", nullable=false)
     */
    private $ico;

    /**
     * @var string
     *
     * @ORM\Column(name="DIC", type="string", length=20, nullable=false)
     */
    private $dic;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_num", type="string", length=20, nullable=false)
     */
    private $phoneNum;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

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

    public function getPaysTax(): ?bool
    {
        return $this->paysTax;
    }

    public function setPaysTax(bool $paysTax): self
    {
        $this->paysTax = $paysTax;

        return $this;
    }

    public function getBankAcc(): ?string
    {
        return $this->bankAcc;
    }

    public function setBankAcc(string $bankAcc): self
    {
        $this->bankAcc = $bankAcc;

        return $this;
    }

    public function getVariableSymbol(): ?int
    {
        return $this->variableSymbol;
    }

    public function setVariableSymbol(int $variableSymbol): self
    {
        $this->variableSymbol = $variableSymbol;

        return $this;
    }

    public function getIco(): ?int
    {
        return $this->ico;
    }

    public function setIco(int $ico): self
    {
        $this->ico = $ico;

        return $this;
    }

    public function getDic(): ?string
    {
        return $this->dic;
    }

    public function setDic(string $dic): self
    {
        $this->dic = $dic;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
