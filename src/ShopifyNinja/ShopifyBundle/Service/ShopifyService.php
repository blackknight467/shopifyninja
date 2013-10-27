<?php

namespace ShopifyNinja\ShopifyBundle\Service;

use ShopifyNinja\ShopifyBundle\Entity\Product;
use ShopifyNinja\ShopifyBundle\Entity\Image;
use ShopifyNinja\ShopifyBundle\Entity\Variant;
use ShopifyNinja\ShopifyBundle\Entity\ShopifyOption;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

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

	public function getAllVariants($array = false)
	{
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Variant')->getAllVariants($array);
	}

	public function getImagesForProduct($products, $array = false)
	{
		return $this->em->getRepository('ShopifyNinjaShopifyBundle:Image')->getImagesForProduct($products, $array);
	}

	public function sync()
	{
		$query = $this->apibase . '/admin/products.json';
		$curlOpts = array(
			CURLOPT_HEADER => false,
			CURLOPT_CONNECTTIMEOUT_MS => 2000,
			CURLOPT_TIMEOUT_MS => 6000
		);

		$ch = curl_init($query);

		curl_setopt_array($ch, $curlOpts);

		$return = curl_exec($ch);

		if ($return === false) {
			// throw exception 
		}
		else {
			$return = json_decode($return, true);

			foreach ($return['products'] as $product) {
				$pid = $product['id'];
				$this->em->getRepository('ShopifyNinjaShopifyBundle:Variants')->find($pid);
				foreach ($product['variants'] as $variant) {
					$vid = $variant['id'];
				}
				foreach ($product['images'] as $image) {
					$iid = $image['id'];
				}
				foreach ($product['options'] as $option) {
					$oid = $option['id'];
				}
			}
		}
	}
}