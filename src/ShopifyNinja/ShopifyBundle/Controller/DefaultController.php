<?php

namespace ShopifyNinja\ShopifyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ShopifyNinjaShopifyBundle:Default:index.html.twig', array('name' => $name));
    }
}
