<?php

namespace ShopifyNinja\ShopifyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="variant")
 * @ORM\Entity(repositoryClass="ShopifyNinja\ShopifyBundle\Repository\VariantRepository")
 */
class Variant
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $barcode;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $compare;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string")
     */
    private $fulfillment;

    /**
     * @ORM\Column(type="integer")
     */
    private $grams;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $inventoryManagement;

    /**
     * @ORM\Column(type="string")
     */
    private $inventroyPolicy;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $option1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $option2;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $option3;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="string")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="\ShopifyNinja\ShopifyBundle\Entity\Product", cascade={"detach"})
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\Column(type="boolean")
     */
    private $shipping;

    /**
     * @ORM\Column(type="string")
     */
    private $sku;

    /**
     * @ORM\Column(type="boolean")
     */
    private $taxable;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="integer")
     */
    private $inventoryQuantity;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     * @return Variant
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
    
        return $this;
    }

    /**
     * Get barcode
     *
     * @return string 
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set compare
     *
     * @param string $compare
     * @return Variant
     */
    public function setCompare($compare)
    {
        $this->compare = $compare;
    
        return $this;
    }

    /**
     * Get compare
     *
     * @return string 
     */
    public function getCompare()
    {
        return $this->compare;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Variant
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set fulfillment
     *
     * @param string $fulfillment
     * @return Variant
     */
    public function setFulfillment($fulfillment)
    {
        $this->fulfillment = $fulfillment;
    
        return $this;
    }

    /**
     * Get fulfillment
     *
     * @return string 
     */
    public function getFulfillment()
    {
        return $this->fulfillment;
    }

    /**
     * Set grams
     *
     * @param integer $grams
     * @return Variant
     */
    public function setGrams($grams)
    {
        $this->grams = $grams;
    
        return $this;
    }

    /**
     * Get grams
     *
     * @return integer 
     */
    public function getGrams()
    {
        return $this->grams;
    }

    /**
     * Set inventoryManagement
     *
     * @param string $inventoryManagement
     * @return Variant
     */
    public function setInventoryManagement($inventoryManagement)
    {
        $this->inventoryManagement = $inventoryManagement;
    
        return $this;
    }

    /**
     * Get inventoryManagement
     *
     * @return string 
     */
    public function getInventoryManagement()
    {
        return $this->inventoryManagement;
    }

    /**
     * Set inventroyPolicy
     *
     * @param string $inventroyPolicy
     * @return Variant
     */
    public function setInventroyPolicy($inventroyPolicy)
    {
        $this->inventroyPolicy = $inventroyPolicy;
    
        return $this;
    }

    /**
     * Get inventroyPolicy
     *
     * @return string 
     */
    public function getInventroyPolicy()
    {
        return $this->inventroyPolicy;
    }

    /**
     * Set option1
     *
     * @param string $option1
     * @return Variant
     */
    public function setOption1($option1)
    {
        $this->option1 = $option1;
    
        return $this;
    }

    /**
     * Get option1
     *
     * @return string 
     */
    public function getOption1()
    {
        return $this->option1;
    }

    /**
     * Set option2
     *
     * @param string $option2
     * @return Variant
     */
    public function setOption2($option2)
    {
        $this->option2 = $option2;
    
        return $this;
    }

    /**
     * Get option2
     *
     * @return string 
     */
    public function getOption2()
    {
        return $this->option2;
    }

    /**
     * Set option3
     *
     * @param string $option3
     * @return Variant
     */
    public function setOption3($option3)
    {
        $this->option3 = $option3;
    
        return $this;
    }

    /**
     * Get option3
     *
     * @return string 
     */
    public function getOption3()
    {
        return $this->option3;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Variant
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Variant
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set product
     *
     * @param integer $product
     * @return Variant
     */
    public function setProduct($product)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return integer 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set shipping
     *
     * @param boolean $shipping
     * @return Variant
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;
    
        return $this;
    }

    /**
     * Get shipping
     *
     * @return boolean 
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set sku
     *
     * @param string $sku
     * @return Variant
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    
        return $this;
    }

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set taxable
     *
     * @param boolean $taxable
     * @return Variant
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
    
        return $this;
    }

    /**
     * Get taxable
     *
     * @return boolean 
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Variant
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Variant
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set inventoryQuantity
     *
     * @param integer $inventoryQuantity
     * @return Variant
     */
    public function setInventoryQuantity($inventoryQuantity)
    {
        $this->inventoryQuantity = $inventoryQuantity;
    
        return $this;
    }

    /**
     * Get inventoryQuantity
     *
     * @return integer 
     */
    public function getInventoryQuantity()
    {
        return $this->inventoryQuantity;
    }
}
