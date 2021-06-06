<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderSubProduct
 *
 * @ORM\Table(name="order_sub_product", indexes={@ORM\Index(name="main_order_meta_id", columns={"main_order_meta_id"}), @ORM\Index(name="sub_order_meta_id", columns={"sub_order_meta_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\OrderSubProductRepository")
 */
class OrderSubProduct
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
     * @var \OrderMeta
     *
     * @ORM\ManyToOne(targetEntity="OrderMeta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="main_order_meta_id", referencedColumnName="id")
     * })
     */
    private $mainOrderMeta;

    /**
     * @var \OrderMeta
     *
     * @ORM\ManyToOne(targetEntity="OrderMeta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sub_order_meta_id", referencedColumnName="id")
     * })
     */
    private $subOrderMeta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainOrderMeta(): ?OrderMeta
    {
        return $this->mainOrderMeta;
    }

    public function setMainOrderMeta(?OrderMeta $mainOrderMeta): self
    {
        $this->mainOrderMeta = $mainOrderMeta;

        return $this;
    }

    public function getSubOrderMeta(): ?OrderMeta
    {
        return $this->subOrderMeta;
    }

    public function setSubOrderMeta(?OrderMeta $subOrderMeta): self
    {
        $this->subOrderMeta = $subOrderMeta;

        return $this;
    }


}
