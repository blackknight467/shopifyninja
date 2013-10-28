<?php

namespace ShopifyNinja\ShopifyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use ShopifyNinja\ShopifyBundle\Entity\Variant;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ShopifyNinjaShopifyBundle:Default:index.html.twig', array('name' => $name));
    }

    public function productsAction()
    {
    	$products = $this->get('shopify')->getAllProducts(true);
        $response = new Response(json_encode($products));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }

    public function variantsAction()
    {
    	$products = $this->get('shopify')->getAllVariants(true);
        $response = new Response(json_encode($products));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }

    public function imagesAction($products)
    {
    	$productArray = explode(',', $products);
    	$images = $this->get('shopify')->getImagesForProduct($productArray, true);
        $response = new Response(json_encode($images));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }

    public function syncAction()
    {
    	$products = $this->get('shopify')->sync();
        $response = new Response(json_encode(array('success' => 1)));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }

    public function comboAction($product)
    {
    	$all = $this->goComboGo($product);
    	$response = new Response(json_encode($all));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }

    public function makeComboAction($product, $entry)
    {
    	$all = $this->goComboGo($product);
    	foreach ($all as $key => $value) {
    		if($value['entry'] == intval($entry)) {
    			$p = $this->get('shopify')->getProductById($product);
    			ldd($p);
    			$now = new \DateTime();
    			$variant = new Variant();
    			$variant->setProduct($p);
    			$variant->setOption1($value['1']);
    			if (array_key_exists('2', $value)) {
    				$variant->setOption2($value['2']);
    			}
    			if (array_key_exists('2', $value)) {
    				$variant->setOption3($value['3']);
    			}
    			$variant->setUpdated($now);
    			$variant->setCreated($now);
    			$variant->setPrice("1.00");
    			$variant->setId(intval($product) + intval($entry));
    			ldd($variant);
    			$this->get('shopify')->save($variant);
    		}
    	}
        $response = new Response(json_encode(array('success' => 1)));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }

    private function goComboGo($product)
    {
    	$variants = $this->get('shopify')->getVariantsForProduct($product);
    	$option1 = array();
    	$option2 = array();
    	$option3 = array();
    	foreach ($variants as $key => $value) {
    		if ($value->getOption1() != null) {
    			$option1[$value->getOption1()] = '' ;
    		}
    		if ($value->getOption2() != null) {
    			$option2[$value->getOption2()] = '' ;
    		}
    		if ($value->getOption3() != null) {
    			$option3[$value->getOption3()] = '' ;
    		}
    	}
    	$all = array();
    	$count = 1;
    	foreach ($option1 as $key1 => $value1) {
    		if (!empty($option2)) {
	    		foreach ($option2 as $key2 => $value2) {
	    			if (!empty($option3)) {
		    			foreach ($option3 as $key3 => $value3) {
		    				$all[] = array('entry'=>$count,'1'=>$key1, '2'=>$key2, '3'=>$key3);
		    				$count++;
		    			}
	    			}
	    			else {
	    				$all[] = array('entry'=>$count,'1'=>$key1, '2'=>$key2);
		    			$count++;
	    			}
	    		}
    		} else {
    			$all[] = array('entry'=>$count,'1'=>$key1);
		    	$count++;
    		}
    	}

    	return $all;
    }

}
