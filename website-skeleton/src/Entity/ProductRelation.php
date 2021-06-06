<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductRelation
 *
 * @ORM\Table(name="product_relation", indexes={@ORM\Index(name="main_product_id", columns={"main_product_id"}), @ORM\Index(name="sub_product_id", columns={"sub_product_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReductRelationRepository")
 */
class ProductRelation
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
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="main_product_id", referencedColumnName="id")
     * })
     */
    private $mainProduct;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sub_product_id", referencedColumnName="id")
     * })
     */
    private $subProduct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainProduct(): ?Product
    {
        return $this->mainProduct;
    }

    public function setMainProduct(?Product $mainProduct): self
    {
        $this->mainProduct = $mainProduct;

        return $this;
    }

    public function getSubProduct(): ?Product
    {
        return $this->subProduct;
    }

    public function setSubProduct(?Product $subProduct): self
    {
        $this->subProduct = $subProduct;

        return $this;
    }


}
