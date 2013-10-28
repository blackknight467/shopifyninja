<?php

namespace ShopifyNinja\ShopifyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
}
