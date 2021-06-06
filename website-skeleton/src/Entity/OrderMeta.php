<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderMeta
 *
 * @ORM\Table(name="order_meta", indexes={@ORM\Index(name="branch_id", columns={"branch_id"}), @ORM\Index(name="order_bill_id", columns={"order_bill_id"}), @ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\OrderMetaRepository")
 */
class OrderMeta
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
     * @ORM\Column(name="money_partner", type="float", precision=10, scale=0, nullable=false)
     */
    private $moneyPartner;

    /**
     * @var float
     *
     * @ORM\Column(name="money_us", type="float", precision=10, scale=0, nullable=false)
     */
    private $moneyUs;

    /**
     * @var bool
     *
     * @ORM\Column(name="done", type="boolean", nullable=false)
     */
    private $done;

    /**
     * @var bool
     *
     * @ORM\Column(name="gift", type="boolean", nullable=false)
     */
    private $gift;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_main_order", type="boolean", nullable=false)
     */
    private $isMainOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="access", type="string", length=50, nullable=false, options={"comment"="public / private"})
     */
    private $access;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=100, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="outcome_data", type="text", length=0, nullable=false)
     */
    private $outcomeData;

    /**
     * @var \Branch
     *
     * @ORM\ManyToOne(targetEntity="Branch")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="branch_id", referencedColumnName="id")
     * })
     */
    private $branch;

    /**
     * @var \OrderBill
     *
     * @ORM\ManyToOne(targetEntity="OrderBill")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_bill_id", referencedColumnName="id")
     * })
     */
    private $orderBill;

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

    public function getMoneyPartner(): ?float
    {
        return $this->moneyPartner;
    }

    public function setMoneyPartner(float $moneyPartner): self
    {
        $this->moneyPartner = $moneyPartner;

        return $this;
    }

    public function getMoneyUs(): ?float
    {
        return $this->moneyUs;
    }

    public function setMoneyUs(float $moneyUs): self
    {
        $this->moneyUs = $moneyUs;

        return $this;
    }

    public function getDone(): ?bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }

    public function getGift(): ?bool
    {
        return $this->gift;
    }

    public function setGift(bool $gift): self
    {
        $this->gift = $gift;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getIsMainOrder(): ?bool
    {
        return $this->isMainOrder;
    }

    public function setIsMainOrder(bool $isMainOrder): self
    {
        $this->isMainOrder = $isMainOrder;

        return $this;
    }

    public function getAccess(): ?string
    {
        return $this->access;
    }

    public function setAccess(string $access): self
    {
        $this->access = $access;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getOutcomeData(): ?string
    {
        return $this->outcomeData;
    }

    public function setOutcomeData(string $outcomeData): self
    {
        $this->outcomeData = $outcomeData;

        return $this;
    }

    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    public function setBranch(?Branch $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function getOrderBill(): ?OrderBill
    {
        return $this->orderBill;
    }

    public function setOrderBill(?OrderBill $orderBill): self
    {
        $this->orderBill = $orderBill;

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
