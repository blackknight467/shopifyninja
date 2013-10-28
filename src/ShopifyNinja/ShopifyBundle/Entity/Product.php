<?php

namespace ShopifyNinja\ShopifyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="ShopifyNinja\ShopifyBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $handle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $scope;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $template;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $vendor;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="\ShopifyNinja\ShopifyBundle\Entity\Variant", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $variants;

    /**
     * @ORM\OneToMany(targetEntity="\ShopifyNinja\ShopifyBundle\Entity\ShopifyOption", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $options;

    /**
     * @ORM\OneToMany(targetEntity="\ShopifyNinja\ShopifyBundle\Entity\Image", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="\ShopifyNinja\ShopifyBundle\Entity\Image", cascade={"detach"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    private $image;


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
     * Set id 
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Product
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get handle
     *
     * @return string 
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Set handle
     *
     * @param string $body
     * @return Product
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    
        return $this;
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Product
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
     * Set type
     *
     * @param string $type
     * @return Product
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set published
     *
     * @param \DateTime $published
     * @return Product
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set scope
     *
     * @param string $scope
     * @return Product
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    
        return $this;
    }

    /**
     * Get scope
     *
     * @return string 
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Product
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    
        return $this;
    }

    /**
     * Get template
     *
     * @return string 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
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
     * @return Product
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
     * Set vendor
     *
     * @param string $vendor
     * @return Product
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    
        return $this;
    }

    /**
     * Get vendor
     *
     * @return string 
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Product
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set variants
     *
     * @param array $variants
     * @return Product
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
    
        return $this;
    }

    /**
     * Get variants
     *
     * @return array 
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * Set options
     *
     * @param array $options
     * @return Product
     */
    public function setOptions($options)
    {
        $this->options = $options;
    
        return $this;
    }

    /**
     * Get options
     *
     * @return array 
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set images
     *
     * @param array $images
     * @return Product
     */
    public function setImages($images)
    {
        $this->images = $images;
    
        return $this;
    }

    /**
     * Get images
     *
     * @return array 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set image
     *
     * @param integer $image
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
     * @return integer 
     */
    public function getImage()
    {
        return $this->image;
    }

    public function loadFromArray($product)
    {
        $this->setBody($product['body_html']);
        $this->setCreated(new \DateTime($product['created_at']));
        $this->setHandle($product['handle']);
        $this->setType($product['product_type']);
        $this->setPublished(new \DateTime($product['published_at']));
        $this->setScope($product['published_scope']);
        $this->setTemplate($product['template_suffix']);
        $this->setTitle($product['title']);
        $this->setUpdated(new \DateTime($product['updated_at']));
        $this->setVendor($product['vendor']);
        $this->setTags($product['tags']);

        return $this;
    }
}
