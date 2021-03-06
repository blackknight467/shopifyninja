<?php

namespace ShopifyNinja\ShopifyBundle\Service;

use ShopifyNinja\ShopifyBundle\Entity\Product;
use ShopifyNinja\ShopifyBundle\Entity\Image;
use ShopifyNinja\ShopifyBundle\Entity\Variant;
use ShopifyNinja\ShopifyBundle\Entity\ShopifyOption;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class ShopifyService
{
	private $container;

	private $em;

	private $key;

	private $password;

	private $secret;

	private $shop;

	private $apibase;

	public function __construct(ContainerInterface $container, EntityManager $em, $key, $password, $secret, $shop)
	{
		$this->container = $container;
		$this->em = $em;
		$this->key = $key;
		$this->password = $password;
		$this->secret = $secret;
		$this->shop = $shop;
		$this->apibase = 'https://'.$key.':'.$password.'@'.$shop.'.myshopify.com';
	}

	public function getAllProducts($array = false)
	{
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Product')->getAllProducts($array);
	}

	public function getProductById($id)
	{
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Product')->getById($id);
	}

	public function getProductsByIds($ids)
	{
		if (empty($ids)) {
			return array();
		}
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Product')->getByIds($ids);
	}

	public function getVariantById($id)
	{
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Variant')->getById($id);
	}

	public function getVariantByOptions($pid, $option1, $option2 = null, $option3 = null)
	{
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Variant')->getByOptions($pid, $option1, $option2, $option3);
	}

	public function getAllVariants($array = false)
	{
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Variant')->getAllVariants($array);
	}

	public function getVariantsForProduct($product, $array = false)
	{
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Variant')->getVariantsForProduct($product, $array);
	}

	public function getImagesForProduct($products, $array = false)
	{
		if (empty($products)) {
			return array();
		}
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Image')->getImagesForProduct($products, $array);
	}

	public function save($obj)
	{
		$this->em->persist($obj);
		$this->em->flush();
	}

	public function sync()
	{
		$query = $this->apibase . '/admin/products.json';
		$curlOpts = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => false,
			CURLOPT_CONNECTTIMEOUT_MS => 2000,
			CURLOPT_TIMEOUT_MS => 6000
		);
		$postOpts = array();
		$putOpts = array();

		$ch = curl_init($query);

		curl_setopt_array($ch, $curlOpts);

		$return = curl_exec($ch);
		curl_close($ch);
		if ($return === false) {
			// throw exception 
		}
		else {
			$return = json_decode($return, true);
			//first pull in all products from shopify

			foreach ($return['products'] as $product) {
				$pid = $product['id'];
				$prod = $this->em->getRepository('ShopifyNinjaShopifyBundle:Product')->find($pid);
				if ($prod == null) {
					$prod = new Product();
					$prod->setId($pid);
				} 
				$prod->loadFromArray($product);

				$this->save($prod);

				foreach ($product['variants'] as $variant) {
					$vid = $variant['id'];
					$var = $this->em->getRepository('ShopifyNinjaShopifyBundle:Variant')->find($vid);
					if ($var == null) {
						$var = new Variant();
						$var->setProduct($prod);
						$var->setId($vid);
						//we might have updated variants on our end, we don't overwrite those
						$var->loadFromArray($variant);

						$this->save($var);
					} 

				}
				foreach ($product['images'] as $image) {
					$iid = $image['id'];
					$im = $this->em->getRepository('ShopifyNinjaShopifyBundle:Image')->find($iid);
					if ($im == null) {
						$im = new Image();
						$im->setProduct($prod);
						$im->setId($iid);
					} 
					$im->loadFromArray($image);

					$this->save($im);

				}
				foreach ($product['options'] as $option) {
					$oid = $option['id'];
					$opt = $this->em->getRepository('ShopifyNinjaShopifyBundle:ShopifyOption')->find($oid);
					if ($opt == null) {
						$opt = new ShopifyOption();
						$opt->setProduct($prod);
						$opt->setId($oid);
					} 
					$opt->loadFromArray($option);

					$this->save($opt);

				}
			}
			//then create the items that aren't in shopify yet
			//NOTE:  spec doesn't include ability for api to create a new product so we'll just leave this stub as is
			// $products = $this->getAllProducts();
			// foreach ($product as $p) {
			// 	$match = false;
			// 	foreach ($return['products'] as $product) {
			// 		if ($p->getId() == $product['id']) {
			// 			$match = true;
			// 		}
			// 	}
			// 	if (!$match) {
			// 		//make a post
			// 	}
			// }

			$variants = $this->getAllVariants();
			foreach ($variants as $v) {
				$match = false;
				foreach ($return['products'] as $product) {
					foreach ($product['variants'] as $var) {
						if ($v->getId() == $var['id']) {
							$match = true;
						} 
					}
				}
				if (!$match) {
					//make a post
					$query = $this->apibase . '/admin/products/'.$v->getProduct()->getId().'/variants.json';
					$newVariant = array('variant' => array('price' => $v->getPrice(), 'option1'=>$v->getOption1()));
					if ($v->getOption3() != null) {
						$newVariant = array('variant' => array('price' => $v->getPrice(), 'option1'=>$v->getOption1(), 'option2'=> $v->getOption2(), 'option3'=> $v->getOption3()));
					} elseif ($v->getOption2() != null) {
						$newVariant = array('variant' => array('price' => $v->getPrice(), 'option1'=>$v->getOption1(), 'option2'=> $v->getOption2()));
					}
					
					$data_string = json_encode($newVariant);
					$ch = curl_init($query);        
					# Return response instead of printing.
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );  
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string );                      
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                                                                                        
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
					    'Content-Type: application/json',                                                                                
					    'Content-Length: ' . strlen($data_string))                                                                       
					);                                                                                                                   
 
					$result = curl_exec($ch);
					$shopV = json_decode($result, true);
					if (array_key_exists('variant', $shopV) ){
						$newV = $shopV['variant'];
						$v->setId($newV['id']);
						$v->loadFromArray($newV);
						$this->save($v);
					}
				}
			}

			//then update the items if the date updated on shopify is different from the db
			//the only thing we update is the inventory, so that's all we'll bother to send to shopify
			foreach ($return['products'] as $product) {
				$pid = $product['id'];
				$prod = $this->em->getRepository('ShopifyNinjaShopifyBundle:Product')->find($pid);
				foreach ($product['variants'] as $variant) {
					$vid = $variant['id'];
					$var = $this->em->getRepository('ShopifyNinjaShopifyBundle:Variant')->find($vid);
					$updated = new \DateTime($variant['updated_at']);
					if ($var->getUpdated() > $updated) {
						//send update to shopify
						//the we only update stock so that's all we'll send
						$query = $this->apibase . '/admin/variants/'.$var->getId().'.json';
						$thing = array('variant' => array('id'=>$var->getId(), 'inventory_quantity'=>$var->getInventoryQuantity()));
						$data_string = json_encode($thing);
						$ch = curl_init($query);                                                             
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");                                                                     
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
						    'Content-Type: application/json',                                                                                
						    'Content-Length: ' . strlen($data_string))                                                                       
						);                                                                                                                   
	 
						$result = curl_exec($ch);
						$shopV = json_decode($result, true);
						if (array_key_exists('variant', $shopV) ){
							$newV = $shopV['variant'];
							$v->setId($newV['id']);
							$v->loadFromArray($newV);
							$this->save($v);
						}
					} 
					else {
						//update our db
						$var->loadFromArray($variant);

						$this->save($var);
					}
				}
			}

		}//end else
	}

}