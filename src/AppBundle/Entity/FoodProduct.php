<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FoodProduct
 *
 * @ORM\Table(name="food_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FoodProductRepository")
 */
class FoodProduct
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expirationDate", type="datetime")
     */
    private $expirationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="elaborationDate", type="datetime")
     */
    private $elaborationDate;

    /**
     * @ORM\OneToOne(targetEntity="Product")
     */
    private $product;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     *
     * @return FoodProduct
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * Set elaborationDate
     *
     * @param string $elaborationDate
     *
     * @return FoodProduct
     */
    public function setElaborationDate($elaborationDate)
    {
        $this->elaborationDate = $elaborationDate;

        return $this;
    }

    /**
     * Get elaborationDate
     *
     * @return \DateTime
     */
    public function getElaborationDate()
    {
        return $this->elaborationDate;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return FoodProduct
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
