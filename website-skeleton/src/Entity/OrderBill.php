<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderBill
 *
 * @ORM\Table(name="order_bill", indexes={@ORM\Index(name="customer_id", columns={"customer_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\OrderBillRepository")
 */
class OrderBill
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
     * @var int
     *
     * @ORM\Column(name="order_num", type="integer", nullable=false)
     */
    private $orderNum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="buy_date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $buyDate = 'CURRENT_TIMESTAMP';

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="payed", type="boolean", nullable=false)
     */
    private $payed;

    /**
     * @var \Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNum(): ?int
    {
        return $this->orderNum;
    }

    public function setOrderNum(int $orderNum): self
    {
        $this->orderNum = $orderNum;

        return $this;
    }

    public function getBuyDate(): ?\DateTimeInterface
    {
        return $this->buyDate;
    }

    public function setBuyDate(\DateTimeInterface $buyDate): self
    {
        $this->buyDate = $buyDate;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPayed(): ?bool
    {
        return $this->payed;
    }

    public function setPayed(bool $payed): self
    {
        $this->payed = $payed;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }


}
