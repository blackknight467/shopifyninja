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
    	$products = $this->get('shopify')->getAllProducts(true);
        $response = new Response(json_encode($products));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }

    public function imagesAction($products)
    {
    	$productArray = explode(',', $products);

    	$products = $this->get('shopify')->getImagesForProduct($productArray, true);
        $response = new Response(json_encode($products));
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }
}
