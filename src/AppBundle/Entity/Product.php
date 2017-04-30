<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @var string
     * @Assert\NotBlank(message="Ingresa un nombre.")
     * @Assert\Length(max=255,maxMessage="No puedes ingresar mas de 255 caracteres.")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message="Ingresa una descripción.")
     * @Assert\Length(max=255,maxMessage="No puedes ingresar mas de 255 caracteres.")
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer
     * @Assert\NotBlank(message="Ingresa un precio.")
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     * @Assert\NotBlank(message="Debes seleccionar una imagen.")
     * @Assert\File(mimeTypes={ "image/*" })
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="Category")
     * @Assert\NotBlank(message="Debe seleccionar una categoría.")
     */
    private $category;

    /**
     *
     * @Assert\Valid
     * @ORM\OneToOne(targetEntity="FoodProduct", mappedBy="product", cascade={"persist", "remove"})
     */
    private $foodProduct;

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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set foodProduct
     *
     * @param \AppBundle\Entity\FoodProduct $foodProduct
     *
     * @return Product
     */
    public function setFoodProduct(\AppBundle\Entity\FoodProduct $foodProduct = null)
    {
        $this->foodProduct = $foodProduct;

        return $this;
    }

    /**
     * Get foodProduct
     *
     * @return \AppBundle\Entity\FoodProduct
     */
    public function getFoodProduct()
    {
        return $this->foodProduct;
    }
}
