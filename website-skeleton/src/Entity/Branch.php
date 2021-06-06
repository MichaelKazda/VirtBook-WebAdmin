<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Branch
 *
 * @ORM\Table(name="branch", indexes={@ORM\Index(name="address_id", columns={"address_id"}), @ORM\Index(name="partner_id", columns={"partner_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\BranchRepository")
 */
class Branch
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
     * @ORM\Column(name="opened_time", type="text", length=0, nullable=false)
     */
    private $openedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="other_services", type="text", length=0, nullable=false)
     */
    private $otherServices;

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
     * @var \Address
     *
     * @ORM\ManyToOne(targetEntity="Address")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * })
     */
    private $address;

    /**
     * @var \Partner
     *
     * @ORM\ManyToOne(targetEntity="Partner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * })
     */
    private $partner;

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

    public function getOpenedTime(): ?string
    {
        return $this->openedTime;
    }

    public function setOpenedTime(string $openedTime): self
    {
        $this->openedTime = $openedTime;

        return $this;
    }

    public function getOtherServices(): ?string
    {
        return $this->otherServices;
    }

    public function setOtherServices(string $otherServices): self
    {
        $this->otherServices = $otherServices;

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

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(?Partner $partner): self
    {
        $this->partner = $partner;

        return $this;
    }


}
