<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductCommission
 *
 * @ORM\Table(name="product_commission", indexes={@ORM\Index(name="partner_id", columns={"partner_id"}), @ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductCommissionRepository")
 */
class ProductCommission
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
     * @var float
     *
     * @ORM\Column(name="commission_us", type="float", precision=10, scale=0, nullable=false, options={"comment"="%"})
     */
    private $commissionUs;

    /**
     * @var \Partner
     *
     * @ORM\ManyToOne(targetEntity="Partner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partner_id", referencedColumnName="id")
     * })
     */
    private $partner;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommissionUs(): ?float
    {
        return $this->commissionUs;
    }

    public function setCommissionUs(float $commissionUs): self
    {
        $this->commissionUs = $commissionUs;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }


}
